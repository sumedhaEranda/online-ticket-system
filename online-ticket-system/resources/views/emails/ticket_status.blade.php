<p>Hi {{ $ticket->customer_name }},</p>

<p>Your support ticket (Ref: <strong>{{ $ticket->reference_no }}</strong>) has been marked as <strong>{{ $status }}</strong>.</p>

<p>You can view the ticket and any updates here:</p>

<p><a href="{{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}">{{ url('/ticket/'.$ticket->reference_no.'/'.$ticket->access_token) }}</a></p>

@if(!empty($ticket->problem_description))
<p>Summary:<br>{{ \Illuminate\Support\Str::limit($ticket->problem_description, 500) }}</p>
@endif

<p>— Support Team</p>
