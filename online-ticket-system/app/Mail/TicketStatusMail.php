<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class TicketStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public string $status;

    public function __construct(Ticket $ticket, string $status)
    {
        $this->ticket = $ticket;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Your ticket status updated — Ref: '.$this->ticket->reference_no)
                    ->view('emails.ticket_status')
                    ->with(['ticket' => $this->ticket, 'status' => $this->status]);
    }
}
