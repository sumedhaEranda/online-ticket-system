@extends('layouts.app')

@section('title','Ticket Status')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-9">

            <!-- HEADER CARD -->
            <div class="card border-0 shadow-lg mb-4 rounded-4">
                <div class="card-body p-4">

                    
                    <div class="mb-3">
                        <h4 class="fw-bold text-primary mb-1">
                            🎫 Ticket Status Overview
                        </h4>
                        <small class="text-muted">
                            Track your support request in real time
                        </small>
                    </div>

                    <hr>

                    <!-- Ticket Info -->
                    <div class="d-flex justify-content-between align-items-start flex-wrap">

                        <div>
                            <h5 class="fw-semibold mb-2">
                                {{ $ticket->problem_description }}
                            </h5>

                            <div class="text-muted small">
                                Ref No:
                                <span class="fw-semibold text-dark">
                                    {{ $ticket->reference_no }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-2 mt-md-0">

                            @php
                                $statusClass = match($ticket->status) {
                                    'Open' => 'bg-success',
                                    'Pending' => 'bg-warning text-dark',
                                    'Resolved' => 'bg-info text-dark',
                                    'Closed' => 'bg-secondary',
                                    default => 'bg-light text-dark'
                                };
                            @endphp

                            <span class="badge fs-6 px-3 py-2 rounded-pill shadow-sm {{ $statusClass }}">
                                {{ $ticket->status }}
                            </span>

                        </div>

                    </div>

                </div>
            </div>


            <!-- CUSTOMER CARD -->
            <div class="card border-0 shadow-sm rounded-4 mb-4"
                 style="border-left: 6px solid #0d6efd;">

                <div class="card-body p-4">

                    <h6 class="text-uppercase text-muted mb-3">
                         Customer Information
                    </h6>

                    <div class="fw-bold fs-5">
                        {{ $ticket->customer_name }}
                    </div>

                    <div class="text-muted mt-1">
                        {{ $ticket->email }}
                    </div>

                    <div class="text-muted">
                         {{ $ticket->phone }}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection