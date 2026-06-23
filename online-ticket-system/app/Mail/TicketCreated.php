<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;
    public Ticket $ticket;

    public function __construct(Ticket $ticket) { $this->ticket = $ticket; }

    public function build()
    {
        return $this->subject('Ticket received — Ref: '.$this->ticket->reference_no)
                    ->view('emails.ticket_created')
                    ->with(['ticket' => $this->ticket]);
    }
}