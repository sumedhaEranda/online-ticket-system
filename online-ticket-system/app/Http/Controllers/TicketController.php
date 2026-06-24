<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\TicketCreated;

class TicketController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth')->except([
            'create', 'store', 'publicView', 'publicByReference',
            'status', 'statusForm', 'checkStatus'
        ]);
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => ['required','regex:/^(07[0-9]{8}|\+94[0-9]{9})$/'],
            'problem_description'=> 'required|string|min:10',
        ]);

        // Tickets inputs
        $data = [
            'customer_name' => trim(strip_tags($validated['customer_name'])),
            'email' => trim($validated['email']),
            'phone' => trim($validated['phone']),
            'problem_description' => trim(strip_tags($validated['problem_description'])),
        ];

        $data['reference_no'] = strtoupper(Str::random(8));
        $data['status'] = 'Open';
        $data['viewed'] = 0;

        if (! auth()->check() && Schema::hasColumn('tickets', 'access_token')) {
            $data['access_token'] = Str::random(48);
        }

        try {
            $ticket = Ticket::create($data);

            try {
                Mail::to($ticket->email)->send(new TicketCreated($ticket));
            } catch (\Throwable $e) {
                \Log::error('Ticket ack email failed: '.$e->getMessage());
            }

            // below use SweetAlert2
            session()->flash('success', 'Ticket created successfully');

            if (! auth()->check()) {
                return view('ticket.success', compact('ticket'));
            }

            return redirect()->route('home')->with('success', 'Ticket created. Reference: '.$ticket->reference_no);

        } catch (\Exception $e) {
            \Log::error('Ticket create failed: '.$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create ticket, please try again later.');
        }
    }

    // public token-protected view
    public function publicView($reference, $token)
    {
        $ticket = Ticket::with('replies.user')
                    ->where('reference_no', $reference)
                    ->where('access_token', $token)
                    ->firstOrFail();

        return view('ticket.status', compact('ticket'));
    }

    public function publicByReference($reference)
    {
        $ticket = \App\Models\Ticket::with('replies.user')
                    ->where('reference_no', $reference)
                    ->first();

        if (! $ticket) {
            return redirect()->route('home')->with('error', 'Ticket not found for reference: '.$reference);
        }

        return view('ticket.status', compact('ticket'));
    }

    public function publicCreate()
    {
        //  public create form 
        return view('ticket.public_create');
    }

    

}