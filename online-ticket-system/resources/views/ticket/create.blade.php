@extends('layouts.app')

@section('content')
<div class="container py-3">

  <h3>Create New Ticket</h3>

  {{-- Alerts are handled globally via SweetAlert2 in layouts.app --}}

  <form id="ticketForm" method="POST" action="{{ route('ticket.store') }}">
    @csrf

    <input type="text" name="customer_name" id="customer_name"
      class="form-control mb-2" placeholder="Customer Name"
      value="{{ old('customer_name') }}" required>

    <input type="email" name="email" id="email"
      class="form-control mb-2" placeholder="Email"
      value="{{ old('email') }}" required>

    <input type="text" name="phone" id="phone"
      class="form-control mb-2" placeholder="Phone (07XXXXXXXX or +94XXXXXXXXX)"
      value="{{ old('phone') }}" required>

    <textarea name="problem_description" id="problem_description"
      class="form-control mb-2" placeholder="Problem Description"
      required>{{ old('problem_description') }}</textarea>

    <button class="btn btn-primary">Submit Ticket</button>
  </form>
</div>

@push('scripts')
<script>
document.getElementById("ticketForm").addEventListener("submit", function (e) {
  let name = document.getElementById("customer_name").value.trim();
  let email = document.getElementById("email").value.trim();
  let phone = document.getElementById("phone").value.trim();
  let description = document.getElementById("problem_description").value.trim();

  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  let phonePattern = /^(07\d{8}|\+94\d{9})$/;

  let errors = [];
  if (!name || !email || !phone || !description) {
    errors.push("All fields are required.");
  }

  if (!emailPattern.test(email)) {
    errors.push("Invalid email format.");
  }

  if (!phonePattern.test(phone)) {
    errors.push("Invalid Sri Lankan phone number. Use 07XXXXXXXX or +94XXXXXXXXX");
  }

  if (errors.length > 0) {
    e.preventDefault();
    Swal.fire({
      icon: 'warning',
      title: 'Please fix the following',
      html: '<ul style="text-align:left">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>',
      width: 600
    });
  }
});
</script>
@endpush
@endsection