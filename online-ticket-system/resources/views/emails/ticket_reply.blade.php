<p>Hi {{ $ticket->customer_name }},</p>

<p>Support agent replied to your ticket (Ref: <strong>{{ $ticket->reference_no }}</strong>):</p>

<blockquote>{{ $reply->message }}</blockquote>

<p>View the ticket and all replies here:</p>
<p><a href="{{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}">
    {{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}
</a></p>

<p>— Support Team</p>