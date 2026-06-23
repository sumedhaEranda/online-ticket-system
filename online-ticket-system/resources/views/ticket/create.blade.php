@extends('layouts.app')

@section('content')
<div class="container py-3">
  <h3>Create Support Ticket</h3>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('ticket.store') }}">
    @csrf

    <input type="text" name="customer_name" class="form-control mb-2" placeholder="Customer Name" value="{{ old('customer_name') }}" required>

    <input type="email" name="email" class="form-control mb-2" placeholder="Email" value="{{ old('email') }}" required>

    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" value="{{ old('phone') }}">

    <textarea name="problem_description" class="form-control mb-2" placeholder="Problem Description" required>{{ old('problem_description') }}</textarea>

    <button class="btn btn-primary">Submit Ticket</button>
  </form>
</div>
@endsection