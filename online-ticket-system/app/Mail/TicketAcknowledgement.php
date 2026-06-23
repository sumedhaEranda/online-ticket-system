<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Mail\Mailable;

class TicketAcknowledgement extends Mailable
{
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->subject('Support Ticket Created')
            ->view('emails.ticket-created');
    }
}