<p>Hi {{ $ticket->customer_name }},</p>

<p>Support agent replied to your ticket (Ref: <strong>{{ $ticket->reference_no }}</strong>):</p>

<blockquote style="border-left:4px solid #eee;padding-left:10px;color:#333">
  {{ $reply->message }}
</blockquote>

<p>View the ticket and all replies here:</p>
<p>
  <a href="{{ $link }}">{{ $link }}</a>
</p>

<p>If you did not request this, ignore this email.</p>

<p>— Support Team</p>