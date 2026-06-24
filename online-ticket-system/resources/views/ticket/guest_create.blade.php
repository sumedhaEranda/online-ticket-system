@extends('layouts.public')

@section('title','Create New Ticket')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="mb-3">Create New Ticket</h4>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form method="POST" action="{{ route('ticket.public.store') }}" id="guestTicketForm">
            @csrf

            <div class="mb-3">
              <label class="form-label">Customer Name *</label>
              <input name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email *</label>
              <input name="email" type="email" class="form-control" value="{{ old('email') }}" required
                     pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}" title="Enter a valid email address">
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input name="phone" class="form-control" value="{{ old('phone') }}" placeholder="07XXXXXXXX or +947XXXXXXXX">
            </div>

            <div class="mb-3">
              <label class="form-label">Problem Description *</label>
              <textarea name="problem_description" rows="5" class="form-control" required>{{ old('problem_description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Ticket</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  var form = document.getElementById('guestTicketForm');
  if (!form) return;
  form.addEventListener('submit', function(e){
    var email = form.querySelector('input[name=email]');
    var re = /^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/;
    if (!re.test(email.value.trim())) {
      e.preventDefault();
      alert('Please enter a valid email address.');
      email.focus();
    }
  });
});
</script>
@endpush