<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = tenancy()->tenant
            ? SupportTicket::where('tenant_id', tenancy()->tenant->id)->latest()->get()
            : collect([]);

        return view('support.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            // 'category' => 'required|string', // If added
        ]);

        $ticket = SupportTicket::create([
            'tenant_id' => tenancy()->tenant->id,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
            // 'ticket_id' => 'TICKET-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)), // If column exists
        ]);

        // Send Email logic (Story 7.4) - simplified for now

        return redirect()->route('support.index')->with('status', 'Ticket created successfully!');
    }

    public function show(SupportTicket $ticket)
    {
        // Simple authorization
        if ($ticket->tenant_id !== tenancy()->tenant->id) {
            abort(403);
        }

        return view('support.show', compact('ticket'));
    }
}
