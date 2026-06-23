<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;

class TicketController extends Controller
{
    public function __construct()
    {
        // require auth for controller actions except public status pages
        $this->middleware('auth')->except(['publicView', 'publicByReference']);
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => 'nullable|string|max:30',
            'problem_description'=> 'required|string|min:10',
        ]);

        $data['reference_no'] = strtoupper(Str::random(8));
        // remove or comment out the next line if not using access_token:
        // $data['access_token'] = Str::random(48);
        $data['status'] = 'Open';
        $data['viewed'] = 0;

        $ticket = Ticket::create($data);

        try {
            Mail::to($ticket->email)->send(new TicketCreated($ticket));
        } catch (\Throwable $e) {
            \Log::error('Ticket ack email failed: '.$e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Ticket created. Reference: '.$ticket->reference_no);
    }

    // public token-protected view
    public function publicView($reference, $token)
    {
        $ticket = Ticket::with('replies.user')
                    ->where('reference_no', $reference)
                    ->where('access_token', $token)
                    ->first();

        if (! $ticket) {
            return redirect()->route('home')->with('error', 'Ticket not found.');
        }

        return view('ticket.status', compact('ticket'))->with('layout', 'layouts.public');
    }

    public function publicByReference($reference)
    {
        $ticket = Ticket::with('replies.user')
                    ->where('reference_no', $reference)
                    ->first();

        if (! $ticket) {
            return redirect()->route('home')->with('error', 'Ticket not found.');
        }

        return view('ticket.status', compact('ticket'))->with('layout', 'layouts.public');
    }

    public function showLookup()
    {
        return view('ticket.lookup');
    }

    public function doLookup(Request $request)
    {
        $data = $request->validate([
            'reference_no' => 'required|string'
        ]);

        $reference = trim($data['reference_no']);

        // Try token route first if exists, otherwise public by reference
        $ticket = Ticket::where('reference_no', $reference)->first();

        if (! $ticket) {
            return redirect()->back()->withErrors(['reference_no' => 'Ticket not found for this reference number.']);
        }

        // prefer token URL if token exists
        if (!empty($ticket->access_token)) {
            return redirect()->route('ticket.public', ['reference' => $ticket->reference_no, 'token' => $ticket->access_token]);
        }

        return redirect()->route('ticket.public.ref', ['reference' => $ticket->reference_no]);
    }
}