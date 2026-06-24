@extends('layouts.public')

@section('title','Create Support Ticket')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="mb-3">Create Support Ticket</h4>

          {{-- Success and validation alerts handled globally via SweetAlert2 in layouts.app --}}

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
              <input name="phone" class="form-control" value="{{ old('phone') }}">
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
document.getElementById('guestTicketForm').addEventListener('submit', function(e){
    var form = this;
    var name = form.querySelector('input[name=customer_name]').value.trim();
    var email = form.querySelector('input[name=email]').value.trim();
    var phone = form.querySelector('input[name=phone]').value.trim();
    var desc = form.querySelector('textarea[name=problem_description]').value.trim();

    var errors = [];
    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneRe = /^(07\d{8}|\+94\d{9})$/;

    if (!name || !email || !phone || !desc) errors.push('All fields are required.');
    if (!emailRe.test(email)) errors.push('Enter a valid email address.');
    if (!phoneRe.test(phone)) errors.push('Phone must be 07XXXXXXXX or +94XXXXXXXXX');

    if (errors.length) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Please fix the following',
            html: '<ul style="text-align:left">' + errors.map(function(it){ return '<li>'+it+'</li>'; }).join('') + '</ul>',
            width: 600
        });
    }
});
</script>
@endpush