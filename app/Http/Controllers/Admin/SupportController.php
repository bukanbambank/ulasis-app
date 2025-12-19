<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(10);
        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $support)
    {
        $support->load(['user', 'replies.user']);
        return view('admin.support.show', compact('support'));
    }

    public function reply(Request $request, SupportTicket $support)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        SupportTicketReply::create([
            'support_ticket_id' => $support->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Optional: Update status to 'in_progress' or 'closed' based on action?
        // For now, let's just keep it simple. Usually admins might close it.
        // Let's allow updating status separately or implicitly.

        if ($support->status === 'open') {
            $support->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
