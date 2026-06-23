@extends('layouts.app')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* Professional, clean styles */
.page-title { font-weight:700; letter-spacing:.2px; }
.card-transparent { border-radius:8px; box-shadow:0 6px 18px rgba(22,28,40,.06); }
.table-sm td, .table-sm th { vertical-align: middle; }
.search-controls .form-control { min-width:220px; }
@media (max-width:768px){
  .search-controls { flex-direction:column; gap:.5rem; }
  .search-controls .form-control { width:100% !important; }
}
</style>
@endpush

@section('title','Overview')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@php
    use App\Models\Ticket;
    use Illuminate\Support\Str;
    $tickets = $tickets ?? Ticket::latest()->take(200)->get();
@endphp

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item text-muted">Dashboard</li>
    <li class="breadcrumb-item active" aria-current="page">Tickets list </li>
  </ol>
</nav>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-3 gap-2">
    <div>
        <h4 class="page-title mb-1">Tickets</h4>
        <div class="text-muted small">Manage and review recent customer requests</div>
    </div>

    <div class="d-flex gap-2 w-100 w-md-auto search-controls">
        @auth
        <a href="{{ route('ticket.create') }}" class="btn btn-primary d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> New Ticket
        </a>
        @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary d-flex align-items-center">
            <i class="bi bi-box-arrow-in-right me-2"></i> Login to create ticket
        </a>
        @endauth

        <select id="statusFilter" class="form-select form-select-sm">
            <option value="">All status</option>
            <option value="Open">Open</option>
            <option value="Pending">Pending</option>
            <option value="Resolved">Resolved</option>
            <option value="Closed">Closed</option>
        </select>

        <div class="input-group input-group-sm">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input id="customerSearch" type="search" class="form-control" placeholder="Search by customer name">
            <button id="clearSearch" class="btn btn-outline-secondary" title="Clear"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>
</div>

<!-- Add a small lookup form (GET) anywhere on home/dashboard -->
<form method="GET" action="{{ route('ticket.status') }}" class="d-flex gap-2">
    <input name="reference_no" class="form-control" placeholder="Enter reference number" required>
    <button class="btn btn-primary">Check Status</button>
</form>
<!-- ...existing code... -->

<div class="card card-transparent">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table id="ticketsTable" class="table table-striped table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $t)
                    <tr class="{{ !$t->viewed ? 'table-warning' : '' }}">
                        <td style="min-width:320px;">
                            <a href="{{ url('/agent/ticket/'.$t->id) }}" class="text-decoration-none fw-medium">
                                {{ Str::limit($t->problem_description,80) }}
                            </a>
                            <div class="small text-muted mt-1">Ref: <strong>{{ $t->reference_no }}</strong></div>
                        </td>

                        <td style="min-width:160px;">
                            <div class="fw-semibold">{{ $t->customer_name }}</div>
                            <div class="small text-muted">{{ $t->email }} · {{ $t->phone }}</div>
                        </td>

                        <td style="min-width:120px;">
                            @php
                                $cls = match($t->status) {
                                    'Open' => 'badge bg-success',
                                    'Pending' => 'badge bg-warning text-dark',
                                    'Resolved' => 'badge bg-info text-dark',
                                    'Closed' => 'badge bg-secondary',
                                    default => 'badge bg-light text-dark'
                                };
                            @endphp
                            <span class="{{ $cls }}">{{ $t->status }}</span>
                            @if(!$t->viewed)
                                <span class="badge bg-info text-dark ms-1">New</span>
                            @endif
                        </td>

                        <td style="min-width:140px;">{{ $t->created_at->format('d-m-Y H:i') }}</td>

                        <td class="text-end" style="min-width:120px;">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-outline-primary" href="{{ url('/agent/ticket/'.$t->id) }}" title="Open ticket">
                                    <i class="bi bi-box-arrow-up-right"></i> Open
                                </a>
                                <a class="btn btn-outline-secondary" href="{{ url('/ticket/status?reference_no='.$t->reference_no) }}" title="View public status">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
        <div>Showing recent {{ $tickets->count() }} tickets</div>
        <div>Use filters to refine results</div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function(){
    var table = $('#ticketsTable').DataTable({
        pageLength: 10,
        lengthChange: true,
        order: [[3,'desc']],
        responsive: true,
        columnDefs: [{ orderable:false, targets: 4 }],
        dom: '<"d-flex justify-content-between mb-2"fB><t><"mt-2"p>',
        language: { search: "Filter:" }
    });

    $('#customerSearch').on('keyup', function(){
        table.column(1).search(this.value).draw();
    });

    $('#statusFilter').on('change', function(){
        table.column(2).search(this.value).draw();
    });

    $('#clearSearch').on('click', function(){
        $('#customerSearch').val('');
        $('#statusFilter').val('');
        table.search('').columns().search('').draw();
    });
});
</script>
@endpush