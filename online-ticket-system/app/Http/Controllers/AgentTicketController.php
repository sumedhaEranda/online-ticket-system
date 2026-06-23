<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketReplyMail;

class AgentTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10)->appends($request->all());

        return view('agent.tickets.index', ['tickets' => $tickets]);
    }

    public function show($id)
    {
        $ticket = Ticket::with('replies.user')->findOrFail($id);

        // mark as viewed
        if (! $ticket->viewed) {
            $ticket->viewed = 1;
            $ticket->save();
        }

        return view('agent.tickets.show', ['ticket' => $ticket]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message'=>'required|string|min:1']);

        $ticket = Ticket::findOrFail($id);

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
        ]);

        $ticket->update(['status' => 'Pending', 'viewed' => 0]);

        try {
            Mail::to($ticket->email)->send(new TicketReplyMail($ticket, $reply));
        } catch (\Throwable $e) {
            \Log::error('Reply email failed: '.$e->getMessage());
        }

        return redirect()->back()->with('success','Reply sent and customer notified.');
    }
    
    public function close(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // change status to Closed (or 'Resolved' as needed)
        $ticket->status = 'Closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket closed.');
    }
}