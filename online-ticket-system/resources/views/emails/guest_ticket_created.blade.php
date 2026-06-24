<p>Hello {{ $ticket->customer_name }},</p>

<p>Your support ticket has been created with reference: <strong>{{ $ticket->reference_no }}</strong>.</p>

<p>Problem Description:</p>
<blockquote>{{ $ticket->problem_description }}</blockquote>

<p>View your ticket and replies at:</p>
<p><a href="{{ $link }}">{{ $link }}</a></p>

<p>Thank you,<br/>Support Team</p>