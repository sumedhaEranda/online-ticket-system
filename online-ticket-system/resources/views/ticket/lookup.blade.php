@extends('layouts.public')

@section('title','Check Ticket Status')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="POST" action="{{ route('ticket.lookup.post') }}">
        @csrf
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Check Ticket Status</h5>

            @if($errors->has('reference_no'))
              <div class="alert alert-danger">{{ $errors->first('reference_no') }}</div>
            @endif

            <div class="mb-3">
              <input name="reference_no" class="form-control" placeholder="Enter reference number" value="{{ old('reference_no') }}" required>
            </div>

            <div class="d-flex justify-content-end">
              <button class="btn btn-primary">Check Status</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection