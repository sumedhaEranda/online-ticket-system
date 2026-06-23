@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Ticket: {{ $ticket->reference_no }}</h3>

    <p><strong>Customer:</strong> {{ $ticket->customer_name }}</p>
    <p><strong>Email:</strong> {{ $ticket->email }}</p>
    <p><strong>Phone:</strong> {{ $ticket->phone }}</p>
    <p><strong>Status:</strong> {{ $ticket->status }}</p>

    <hr>

    <h5>Problem Description</h5>
    <p>{{ $ticket->problem_description }}</p>

    <hr>

    <h5>Replies</h5>

    @foreach($ticket->replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                {{ $reply->message }}
                <div class="text-muted small">by {{ optional($reply->user)->name ?? 'Agent' }} • {{ $reply->created_at }}</div>
            </div>
        </div>
    @endforeach

</div>

@endsection
