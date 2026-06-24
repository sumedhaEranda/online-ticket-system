@extends('layouts.public')

@section('title','Ticket '.$ticket->reference_no)

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-body">
          <h5>Problem Description</h5>
          <p>{!! nl2br(e($ticket->problem_description)) !!}</p>
          <p class="text-muted">Ref: <strong>{{ $ticket->reference_no }}</strong></p>
          <p class="text-muted">Status: <strong>{{ $ticket->status }}</strong></p>
        </div>
      </div>

      <h6>Replies</h6>
      @forelse($ticket->replies as $reply)
        <div class="card mb-2">
          <div class="card-body">{!! nl2br(e($reply->message)) !!}</div>
        </div>
      @empty
        <div class="text-muted">No replies yet.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection