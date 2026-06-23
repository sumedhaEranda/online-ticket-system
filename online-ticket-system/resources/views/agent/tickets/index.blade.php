@extends('layouts.app')

@section('title','Tickets')

@section('content')

<div class="container py-4">

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <form class="row g-2 align-items-center" method="GET">

                <div class="col-12 col-md-5">
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search by customer or reference...">
                </div>

                <div class="col-6 col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Open" {{ request('status')=='Open'?'selected':'' }}>Open</option>
                        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                        <option value="Resolved" {{ request('status')=='Resolved'?'selected':'' }}>Resolved</option>
                        <option value="Closed" {{ request('status')=='Closed'?'selected':'' }}>Closed</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>

                <div class="col-12 col-md-2">
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-ticket-detailed me-2"></i>
                Ticket List
            </h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">#</th>
                            <th>Problem Description</th>
                            <th style="width:160px;">Reference</th>
                            <th style="width:130px;">Status</th>
                            <th style="width:140px;" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($tickets as $ticket)

                            <tr class="{{ !$ticket->viewed ? 'table-warning' : '' }}">

                                <td class="text-muted">
                                    {{ $ticket->id }}
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ \Illuminate\Support\Str::limit($ticket->problem_description, 70) }}
                                    </div>

                                    <small class="text-muted">
                                        Customer: {{ $ticket->customer_name ?? 'N/A' }}
                                    </small>
                                </td>

                                <td>
                                    <strong>{{ $ticket->reference_no }}</strong>
                                </td>

                                <td>
                                    @php
                                        $badge = match($ticket->status) {
                                            'Open' => 'bg-success',
                                            'Pending' => 'bg-warning text-dark',
                                            'Resolved' => 'bg-info text-dark',
                                            'Closed' => 'bg-secondary',
                                            default => 'bg-light text-dark'
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">
                                        {{ $ticket->status }}
                                    </span>

                                    @if(!$ticket->viewed)
                                        <span class="badge bg-primary ms-1">New</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ url('/agent/ticket/'.$ticket->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>
                                        Open
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No tickets found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- PAGINATION -->
    <div class="mt-3">
        <div class="d-flex justify-content-end">
            {{ $tickets->links() }}
        </div>
    </div>

</div>

@endsection