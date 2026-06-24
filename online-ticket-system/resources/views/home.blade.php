
@extends('layouts.app')

@section('title','Dashboard')

@push('head')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<style>
body {
    background: #f5f7fb;
}

/* Page enter animation */
.page-enter {
    animation: pageFade 0.6s ease;
}

@keyframes pageFade {
    from {
        opacity: 0;
        transform: scale(0.98);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Success alert animation */
.alert-success {
    border-radius: 10px;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Page title */
.page-title {
    font-weight: 700;
    color: #111827;
}

/* Card */
.card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* Table header */
.table thead th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb !important;
}

/* Row hover */
.table-hover tbody tr {
    transition: 0.2s;
}

.table-hover tbody tr:hover {
    background: #eef4ff;
    transform: scale(1.01);
}

/* Search bar */
.search-controls {
    background: #fff;
    padding: 12px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

/* Buttons */
.btn-primary {
    border-radius: 10px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
}

/* Badges */
.badge {
    border-radius: 8px;
    padding: 6px 10px;
}
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@php
    use App\Models\Ticket;
    use Illuminate\Support\Str;
    $tickets = $tickets ?? Ticket::latest()->take(200)->get();
@endphp

<!-- HEADER -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-3 gap-3">

    
    <div class="d-flex flex-column gap-2">

        @auth
            <a href="{{ route('ticket.create') }}" class="btn btn-primary w-fit">
                <i class="bi bi-plus-lg me-1"></i> New Ticket
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary w-fit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
        @endauth

        <h4 class="page-title mb-0">Tickets List</h4>
        <div class="text-muted small">Manage and track customer support requests</div>

        
    </div>



</div>
<div class="d-flex gap-3 align-items-center search-controls">
    
    <div style="min-width:160px;">
        <select id="statusFilter" class="form-select form-select-sm">
            <option value="">All status</option>
            <option value="Open">Open</option>
            <option value="Pending">Pending</option>
            <option value="Resolved">Resolved</option>
            <option value="Closed">Closed</option>
        </select>
    </div>

    <div class="input-group input-group-sm" style="min-width:260px;">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>

        <input id="customerSearch"
               type="search"
               class="form-control"
               placeholder="Search customer">

        <button id="clearSearch" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

</div>

<!-- TABLE CARD -->
<div class="card card-modern border-0">

    <div class="card-body p-2">

        <div class="table-responsive">

            <table id="ticketsTable"
                   class="table table-bordered table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Problem</th>
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
                            <a href="{{ url('/agent/ticket/'.$t->id) }}"
                               class="text-decoration-none fw-semibold text-dark">
                                {{ Str::limit($t->problem_description, 80) }}
                            </a>

                            <div class="text-muted small mt-1">
                                Ref: <strong>{{ $t->reference_no }}</strong>
                            </div>
                        </td>

                        <td>
                            <div class="fw-semibold">{{ $t->customer_name }}</div>
                            <div class="text-muted small">
                                {{ $t->email }} · {{ $t->phone }}
                            </div>
                        </td>

                        <td>
                            @php
                                $cls = match($t->status) {
                                    'Open' => 'bg-success',
                                    'Pending' => 'bg-warning text-dark',
                                    'Resolved' => 'bg-info text-dark',
                                    'Closed' => 'bg-secondary',
                                    default => 'bg-light text-dark'
                                };
                            @endphp

                            <span class="badge {{ $cls }}">
                                {{ $t->status }}
                            </span>

                            @if(!$t->viewed)
                                <span class="badge bg-primary ms-1">New</span>
                            @endif
                        </td>

                        <td class="text-muted">
                            {{ $t->created_at->format('d-m-Y H:i') }}
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">

                                <a href="{{ url('/agent/ticket/'.$t->id) }}"
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>

                                <a href="{{ url('/ticket/status?reference_no='.$t->reference_no) }}"
                                   class="btn btn-outline-secondary">
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

    <div class="card-footer bg-white d-flex justify-content-between small text-muted">
        <div>Total: {{ $tickets->count() }} tickets</div>
        <div>Use filters to refine results</div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function(){

    var table = $('#ticketsTable').DataTable({
        pageLength: 10,
        order: [[3,'desc']],
        columnDefs: [{ orderable:false, targets: 4 }],
        dom: '<"d-flex justify-content-between mb-2"f>t<"d-flex justify-content-between mt-2"ip>',
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

