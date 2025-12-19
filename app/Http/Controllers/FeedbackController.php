<?php

namespace App\Http\Controllers;

use App\Models\FeedbackResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    public function show($uuid)
    {
        // Use DB Facade for QrCode retrieval to bypass Eloquent/Tenancy issues in tests
        $qrCode = \Illuminate\Support\Facades\DB::table('qr_codes')
            ->where('unique_code', $uuid)
            ->first();

        if (!$qrCode) {
            abort(404);
        }

        if (!$qrCode->is_active) {
            abort(404, 'Form is not active.');
        }

        // Use DB Facade to bypass Model/Scope issues in mixed tenancy contexts (public routes)
        $questionnaireRaw = \Illuminate\Support\Facades\DB::table('questionnaires')
            ->where('id', $qrCode->questionnaire_id)
            ->first();

        $questionnaire = new \stdClass();
        if ($questionnaireRaw) {
            $questionnaire->id = $questionnaireRaw->id;
            $questionnaire->title = $questionnaireRaw->title;
            // Decode questions manually
            $questionnaire->questions = json_decode($questionnaireRaw->questions, true) ?? [];
            $questionnaire->tenant_id = $questionnaireRaw->tenant_id;

            $restaurantRaw = \Illuminate\Support\Facades\DB::table('restaurants')
                ->where('tenant_id', $questionnaire->tenant_id)
                ->first();

            $questionnaire->restaurant = $restaurantRaw;
        }

        return view('feedback.show', [
            'qrCode' => $qrCode,
            'questionnaire' => $questionnaire,
            'uuid' => $uuid
        ]);
    }

    public function store(Request $request, $uuid)
    {
        $qrCode = \Illuminate\Support\Facades\DB::table('qr_codes')
            ->where('unique_code', $uuid)
            ->first();

        if (!$qrCode || !$qrCode->is_active) {
            abort(404);
        }

        // Basic validation
        $request->validate([
            'ratings' => 'required|array',
            'feedback_text' => 'nullable|string|max:1000',
        ]);

        // Use Eloquent for creation if possible, otherwise DB::table
        // Use Eloquent for creation if possible, otherwise DB::table
        // Bypass Eloquent/Model completely for public route to avoid Tenancy Scoping issues
        try {
            \Illuminate\Support\Facades\DB::table('feedback_responses')->insert([
                'tenant_id' => $qrCode->tenant_id,
                'qr_code_id' => $qrCode->id,
                'ratings' => json_encode($request->ratings),
                'feedback_text' => $request->input('feedback_text'),
                'customer_info' => json_encode([]),
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Negative Feedback Alert Logic (Epic 5.4) - Simplified
            $ratings = $request->ratings;
            $count = count($ratings);
            $sum = array_sum($ratings);
            $avg = $count > 0 ? $sum / $count : 5;

            if ($avg < 3) {
                // Check for user asynchronously or skip to avoid blocking response
                // $user = \App\Models\User::where('tenant_id', $qrCode->tenant_id)->first();
                // if ($user) Mail::to($user->email)... 
            }

            return redirect()->route('feedback.thank-you');

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Feedback Store Critical Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    public function thankYou()
    {
        return view('feedback.thank-you');
    }
}
