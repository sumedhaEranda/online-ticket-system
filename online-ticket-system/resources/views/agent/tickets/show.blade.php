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

<form action="{{ route('agent.ticket.close', $ticket->id) }}" method="POST" data-swal-confirm="true"
      data-swal-title="Close ticket?"
      data-swal-text="Are you sure you want to close this ticket? This action can be undone by support."
      data-swal-confirm-button="Close"
      data-swal-cancel-button="Cancel"
      class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger btn-responsive">Close Ticket</button>
</form>

</div>

@endsection