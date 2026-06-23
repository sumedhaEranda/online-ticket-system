<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;
use App\Models\TicketReply;

class TicketReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public TicketReply $reply;

    public function __construct(Ticket $ticket, TicketReply $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Reply to your ticket — Ref: '.$this->ticket->reference_no)
                    ->view('emails.ticket_reply')
                    ->with([
                        'ticket' => $this->ticket,
                        'reply'  => $this->reply,
                        'link'   => url('/ticket/'.$this->ticket->reference_no.'/'.($this->ticket->access_token ?? '')),
                    ]);
    }
}