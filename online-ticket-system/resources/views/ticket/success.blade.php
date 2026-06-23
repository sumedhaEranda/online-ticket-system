@extends('layouts.app')

@section('title','Ticket Created')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4 class="mb-2">Ticket Created</h4>
        <p class="mb-2">Your ticket reference number:</p>
        <h5 class="fw-bold">{{ $ticket->reference_no ?? session('reference_no') }}</h5>
        <p class="small text-muted mt-2">An acknowledgement email has been sent to {{ $ticket->email ?? '' }}.</p>

        <div class="mt-3">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-responsive">Back to Home</a>
            <a href="{{ url('/ticket/status?reference_no='.($ticket->reference_no ?? session('reference_no'))) }}" class="btn btn-primary btn-responsive">View Ticket</a>
        </div>
    </div>
</div>
@endsection
