@extends('layouts.public')

@section('title', 'Ticket '.$ticket->reference_no)

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card text-center">
        <div class="card-body">
          <h4 class="mb-2">Reference</h4>
          <h3 class="fw-bold">{{ $ticket->reference_no }}</h3>

          <hr>

          <h5 class="mb-0">Status</h5>
          <p class="mt-1">
            <span class="badge {{
              $ticket->status === 'Open' ? 'bg-success' :
              ($ticket->status === 'Pending' ? 'bg-warning text-dark' :
              ($ticket->status === 'Resolved' ? 'bg-info text-dark' :
              ($ticket->status === 'Closed' ? 'bg-secondary' : 'bg-light text-dark')))
            }}">
              {{ $ticket->status ?? 'Unknown' }}
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection