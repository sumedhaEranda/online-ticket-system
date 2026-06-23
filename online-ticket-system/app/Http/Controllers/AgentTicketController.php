<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketReplyMail;
use Illuminate\Support\Facades\Log;

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
        $request->validate(['message' => 'required|string']);

        $ticket = Ticket::findOrFail($id);

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
        ]);

        // update ticket status
        $ticket->update(['status' => 'Pending', 'viewed' => 0]);

        // send email synchronously and log on failure
        try {
            Mail::to($ticket->email)->send(new TicketReplyMail($ticket, $reply));
            // If you use queueing and want immediate send, use Mail::to(...)->send(...) as above
        } catch (\Throwable $e) {
            Log::error('Ticket reply email failed for ticket '.$ticket->id.' : '.$e->getMessage());
            // optionally attach flash message for UI
            return redirect()->back()->with('error','Reply saved but email failed to send.');
        }

        return redirect()->back()->with('success','Reply posted and customer notified.');
    }
    
    public function close(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // change status to Closed (or 'Resolved' as needed)
        $ticket->status = 'Closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket closed.');
    }

    public function resolve(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => 'Resolved']);
        return redirect()->back()->with('success','Ticket marked resolved.');
    }

    /**
     * Alias for routes using "Resolved" — keeps backward compatibility.
     */
    public function Resolved(Request $request, $id)
    {
        return $this->resolve($request, $id);
    }

    public function data(Request $request)
    {
        $status = $request->query('status'); // expected values: Open, Pending, Resolved, Closed or null
        $query = Ticket::query();

        if ($status) {
            // allow lowercase hashes like #open
            $statusMap = [
                'open' => 'Open',
                'pending' => 'Pending',
                'resolved' => 'Resolved',
                'closed' => 'Closed'
            ];
            $key = strtolower($status);
            if (isset($statusMap[$key])) {
                $query->where('status', $statusMap[$key]);
            }
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        $rows = $tickets->map(function($t){
            return [
                'id' => $t->id,
                'subject' => \Illuminate\Support\Str::limit($t->problem_description, 80),
                'customer' => $t->customer_name,
                'status' => $t->status,
                'created_at' => $t->created_at->format('d-m-Y H:i'),
                'reference_no' => $t->reference_no,
                'viewed' => $t->viewed,
                'actions' => view('agent.tickets.partials.actions', ['ticket'=>$t])->render()
            ];
        });

        return response()->json(['data' => $rows]);
    }
}