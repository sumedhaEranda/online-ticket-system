@extends('layouts.app')

@section('title','Ticket Status')

@section('content')
<div class="container py-4">
    <h5>Ref: {{ $ticket->reference_no }} — {{ $ticket->status }}</h5>
    <p><strong>{{ $ticket->customer_name }}</strong> · {{ $ticket->email }} · {{ $ticket->phone }}</p>
    <p>{{ $ticket->problem_description }}</p>

    <h6>Replies</h6>
    @foreach($ticket->replies as $r)
        <div class="card mb-2"><div class="card-body">{{ $r->message }} <div class="text-muted small">{{ $r->created_at }}</div></div></div>
    @endforeach
</div>
@endsection