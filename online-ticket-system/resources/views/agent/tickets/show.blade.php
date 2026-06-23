@extends('layouts.app')

@section('content')

<div class="container">

<h4>{{ $ticket->reference_no }}</h4>

<p>{{ $ticket->problem_description }}</p>

<hr>

@foreach($ticket->replies as $reply)

<div class="card mb-2">
<div class="card-body">
{{ $reply->message }}
</div>
</div>

@endforeach

<form method="POST">

@csrf

<textarea
name="message"
class="form-control">
</textarea>

<button
formaction="/agent/ticket/{{$ticket->id}}/reply"
class="btn btn-primary mt-2">

Send Reply

</button>

</form>

<form action="{{ route('agent.ticket.close', $ticket->id) }}" method="POST" onsubmit="return confirm('Close this ticket?');">
    @csrf
    <button type="submit" class="btn btn-danger">Close Ticket</button>
</form>

</div>

@endsection