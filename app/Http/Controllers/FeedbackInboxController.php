<?php

namespace App\Http\Controllers;

use App\Models\FeedbackResponse;
use Illuminate\Http\Request;

class FeedbackInboxController extends Controller
{
    public function index(Request $request)
    {
        // Bypass TenancyScope if active, and manually enforce User's Tenant ID
        $query = FeedbackResponse::query()
            ->withoutGlobalScopes()
            ->where('tenant_id', \Illuminate\Support\Facades\Auth::user()->tenant_id)
            ->with('qrCode')
            ->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where('feedback_text', 'like', '%' . $request->search . '%')
                ->orWhereHas('qrCode', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        $feedbacks = $query->paginate(20);

        return view('feedback-inbox.index', compact('feedbacks'));
    }

    public function update(Request $request, FeedbackResponse $feedback)
    {
        $request->validate([
            'status' => 'required|in:unread,read,archived'
        ]);

        $feedback->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function show(FeedbackResponse $feedback)
    {
        return view('feedback-inbox.show', compact('feedback'));
    }

    public function destroy(FeedbackResponse $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback-inbox.index')->with('success', 'Feedback deleted.');
    }
}
