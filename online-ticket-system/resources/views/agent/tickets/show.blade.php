@extends('layouts.app')

@section('title', 'Ticket '.$ticket->reference_no)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Ticket Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                        <div>
                            <h4 class="fw-bold mb-1">
                                Ticket #{{ $ticket->reference_no }}
                            </h4>

                            <div class="text-muted small">
                                Created on
                                {{ $ticket->created_at->format('d M Y h:i A') }}
                            </div>
                        </div>

                        <div class="mt-3 mt-md-0">
                            <span class="badge px-3 py-2 fs-6
                                {{ $ticket->status === 'Open'
                                    ? 'bg-success'
                                    : ($ticket->status === 'Pending'
                                        ? 'bg-warning text-dark'
                                        : 'bg-secondary') }}">
                                {{ $ticket->status }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Customer Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">
                                Customer Name
                            </small>

                            <strong>
                                {{ $ticket->customer_name ?? 'N/A' }}
                            </strong>
                        </div>

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">
                                Email
                            </small>

                            <strong>
                                {{ $ticket->email ?? 'N/A' }}
                            </strong>
                        </div>

                        <div class="col-md-4 mb-3">
                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <strong>
                                {{ $ticket->phone ?? 'N/A' }}
                            </strong>
                        </div>

                    </div>

                    <hr>

                    <small class="text-muted d-block mb-2">
                        Problem Description
                    </small>

                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($ticket->problem_description ?? 'No Description')) !!}
                    </div>

                </div>
            </div>

            <!-- Conversation -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Conversation
                </h4>
            </div>

            @forelse($ticket->replies()->oldest()->get() as $reply)

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">

                        <div class="d-flex align-items-start gap-3">

                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                 style="width:45px;height:45px;min-width:45px;">
                                {{ strtoupper(substr($reply->user?->name ?? ($reply->author_name ?? 'C'), 0, 1)) }}
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <strong>
                                            {{ $reply->user?->name ?? ($reply->author_name ?? 'Customer') }}
                                        </strong>

                                        @if($reply->user_id)
                                            <span class="badge bg-primary ms-2">
                                                Agent
                                            </span>
                                        @endif
                                    </div>

                                    <small class="text-muted">
                                        {{ $reply->created_at->format('d M Y h:i A') }}
                                    </small>

                                </div>

                                <hr>

                                <div>
                                    {!! nl2br(e($reply->message)) !!}
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            @empty

                <div class="alert alert-light border">
                    No replies yet.
                </div>

            @endforelse

            <!-- Reply Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-reply-fill me-2"></i>
                        Reply to Ticket
                    </h5>
                </div>

                <div class="card-body">

                      @php
                        $isResolved = ($ticket->status === 'Resolved');
                        $isClosed = ($ticket->status === 'Closed');
                        $disableReply = $isResolved || $isClosed;
                        $disableResolve = $isResolved || $isClosed;
                        $disableClose = $isClosed;
                      @endphp

                      <form id="replyForm"
                          action="/agent/ticket/{{ $ticket->id }}/reply"
                          method="POST">

                        @csrf

                        <div class="mb-3">
                            <textarea
                                name="message"
                                rows="5"
                                class="form-control"
                                placeholder="Type your reply here..."
                                @if($disableReply) disabled @else required @endif>{{ old('message') }}</textarea>
                        </div>

                        @if($disableReply)
                            <div class="alert alert-warning small">
                                Replies are disabled for tickets that are {{ $ticket->status }}.
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

                            <div>
                                <button id="sendReplyBtn"
                                        type="submit"
                                        class="btn btn-primary"
                                        @if($disableReply) disabled @endif>
                                    <i class="bi bi-send me-1"></i>
                                    Send Reply
                                </button>

                                <button type="button"
                                        class="btn btn-outline-secondary ms-2"
                                        onclick="document.querySelector('[name=message]').value=''">
                                    Clear
                                </button>
                            </div>

                            <div class="text-muted small align-self-center">
                                Reference No:
                                <strong>{{ $ticket->reference_no }}</strong>
                            </div>

                        </div>

                    </form>

                    <hr class="my-4">

                    <!-- Ticket Actions -->
                    <div class="d-flex flex-wrap justify-content-end gap-2">

                        <form action="{{ route('agent.ticket.Resolved', $ticket->id) }}"
                              method="POST"
                              data-swal-confirm="true"
                              data-swal-title="Resolve Ticket?"
                              data-swal-text="Are you sure you want to mark this ticket as resolved?"
                              data-swal-confirm-button="Resolve"
                              data-swal-cancel-button="Cancel">
                            @csrf

                            <button type="submit" class="btn btn-success" @if($disableResolve) disabled @endif>
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Mark as Resolved
                            </button>
                        </form>

                        <form action="{{ route('agent.ticket.close', $ticket->id) }}"
                              method="POST"
                              data-swal-confirm="true"
                              data-swal-title="Close Ticket?"
                              data-swal-text="Are you sure you want to close this ticket?"
                              data-swal-confirm-button="Close"
                              data-swal-cancel-button="Cancel">
                            @csrf

                            <button type="submit" class="btn btn-danger" @if($disableClose) disabled @endif>
                                <i class="bi bi-lock-fill me-1"></i>
                                Close Ticket
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('replyForm');
    const btn = document.getElementById('sendReplyBtn');

    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
        });
    }

});
</script>
@endpush

@endsection
