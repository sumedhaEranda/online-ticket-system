<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class GuestTicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        $link = url('/ticket/'.$this->ticket->reference_no.'/'.$this->ticket->access_token);
        return $this->subject('Your ticket has been created — Ref: '.$this->ticket->reference_no)
                    ->view('emails.guest_ticket_created')
                    ->with([
                        'ticket' => $this->ticket,
                        'link' => $link,
                    ]);
    }
}