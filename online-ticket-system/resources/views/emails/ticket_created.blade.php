<p>Hi {{ $ticket->customer_name }},</p>

<p>We received your support ticket. Reference: <strong>{{ $ticket->reference_no }}</strong></p>

<p>To check the status and replies, open this secure link (do not share):</p>

<p><a href="{{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}">
    {{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}
</a></p>

<p>Summary:<br>{{ \Illuminate\Support\Str::limit($ticket->problem_description, 500) }}</p>

<p>— Support Team</p>