@extends('layouts.app')

@section('title','Tickets')

@section('content')
<div class="row mb-3">
    <div class="col-12 col-md-8">
        <form class="row g-2" method="GET">
            <div class="col-6 col-sm-4">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search customer">
            </div>
            <div class="col-4 col-sm-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Open" {{ request('status')=='Open'?'selected':'' }}>Open</option>
                    <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                    <option value="Resolved" {{ request('status')=='Resolved'?'selected':'' }}>Resolved</option>
                    <option value="Closed" {{ request('status')=='Closed'?'selected':'' }}>Closed</option>
                </select>
            </div>
            <div class="col-2 col-sm-2">
                <button class="btn btn-primary btn-responsive" type="submit">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    @forelse($tickets as $ticket)
        <div class="col-12 mb-2">
            <div class="card ticket-card {{ $ticket->viewed ? '' : 'border-start border-4 border-info' }}">
                <div class="card-body d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $ticket->customer_name }} 
                            <small class="text-muted">— {{ $ticket->reference_no }}</small>
                        </h6>
                        <p class="mb-1 text-truncate">{{ $ticket->problem_description }}</p>
                        <div class="ticket-meta text-muted">
                            <small>{{ $ticket->email }} · {{ $ticket->phone }} · {{ $ticket->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <div class="mt-2 mt-sm-0 ms-sm-3 d-grid gap-2 d-sm-flex align-items-center">
                        @if(! $ticket->viewed)
                            <span class="badge bg-info text-dark me-1">New</span>
                        @endif
                        <a href="{{ url('/agent/ticket/'.$ticket->id) }}" class="btn btn-outline-primary btn-sm btn-responsive">Open</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary">No tickets found.</div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $tickets->links() }}
</div>
@endsection