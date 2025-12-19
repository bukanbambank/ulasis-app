<?php

namespace App\Http\Controllers;

use App\Models\QrCode as QrCodeModel;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant ?? \App\Models\Restaurant::where('tenant_id', Auth::user()->tenant_id)->first();

        $qrCodes = $restaurant ?
            $restaurant->qrCodes()->with('questionnaire')->latest()->paginate(10) :
            new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

        return view('qr-codes.index', compact('qrCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questionnaires = Auth::user()->restaurant ?
            Auth::user()->restaurant->questionnaires :
            collect([]);

        return view('qr-codes.create', compact('questionnaires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'questionnaire_id' => 'required|exists:questionnaires,id',
            'name' => 'required|string|max:255',
        ]);

        $restaurant = Auth::user()->restaurant ?? \App\Models\Restaurant::where('tenant_id', Auth::user()->tenant_id)->firstOrFail();

        // Ensure questionnaire belongs to tenant
        $questionnaire = $restaurant->questionnaires()->findOrFail($request->questionnaire_id);

        $uniqueCode = (string) Str::uuid();
        $fileName = $uniqueCode . '.png';
        $path = 'qr-codes/' . Auth::user()->tenant_id . '/' . $fileName;

        // Ensure directory exists
        if (!Storage::disk('public')->exists('qr-codes/' . Auth::user()->tenant_id)) {
            Storage::disk('public')->makeDirectory('qr-codes/' . Auth::user()->tenant_id);
        }

        // Generate QR Code content (URL to feedback form)
        $url = route('feedback.show', $uniqueCode);

        // Generate Image (External API fallback due to missing local package)
        $qrContent = urlencode($url);
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$qrContent}";

        // Fetch image from API
        $image = file_get_contents($apiUrl);

        if ($image === false) {
            return back()->withErrors(['qr_code' => 'Failed to generate QR code via external service.']);
        }

        Storage::disk('public')->put($path, $image);

        $restaurant->qrCodes()->create([
            'questionnaire_id' => $questionnaire->id,
            'name' => $request->name,
            'unique_code' => $uniqueCode,
            'image_path' => $path,
            'is_active' => true,
        ]);

        return redirect()->route('qr-codes.index')->with('status', 'qr-code-generated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QrCodeModel $qrCode)
    {
        if ($qrCode->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        if (Storage::disk('public')->exists($qrCode->image_path)) {
            Storage::disk('public')->delete($qrCode->image_path);
        }

        $qrCode->delete();

        return back()->with('status', 'qr-code-deleted');
    }

    public function download(QrCodeModel $qrCode)
    {
        if ($qrCode->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($qrCode->image_path)) {
            // Debugging: Log path
            \Illuminate\Support\Facades\Log::error("QR Code missing at: " . $qrCode->image_path);

            // Regeneration fallback if missing!
            $url = route('feedback.show', $qrCode->unique_code);
            $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
            $image = @file_get_contents($apiUrl);

            if ($image) {
                Storage::disk('public')->put($qrCode->image_path, $image);
            } else {
                // Return visible error for user debugging
                return response("Error: File missing and regeneration failed. Path: {$qrCode->image_path}. API: {$apiUrl}", 404);
            }
        }

        $content = Storage::disk('public')->get($qrCode->image_path);

        if (!$content) {
            return response("Error: content could not be read from storage. Path: {$qrCode->image_path}", 500);
        }

        // Sanitize filename to ensure generic browser compatibility
        $filename = \Illuminate\Support\Str::slug($qrCode->name) . '.png';

        // Clean output buffer to prevent corruption
        if (ob_get_length()) {
            ob_end_clean();
        }

        return response($content)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            // Add explicit binary transfer encoding
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-Length', strlen($content))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
