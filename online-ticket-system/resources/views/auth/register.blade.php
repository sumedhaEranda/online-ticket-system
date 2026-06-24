@extends('layouts.app')

@push('head')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container auth-layout">

    <div class="card auth-card">

        <div class="auth-card-header">
            Create Support Agent Account
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-2">
                    <label class="form-label">Password</label>

                    <div class="input-group">
                        <input id="password"
                               type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password"
                               oninput="checkPassword(this.value)"
                               required>

                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i id="eyeIcon" class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD POLICY -->
                <div class="password-policy mb-3">
                    <div id="rule-length" class="text-danger">✖ At least 8 characters</div>
                    <div id="rule-upper" class="text-danger">✖ One uppercase letter</div>
                    <div id="rule-lower" class="text-danger">✖ One lowercase letter</div>
                    <div id="rule-number" class="text-danger">✖ One number</div>
                    <div id="rule-special" class="text-danger">✖ One special character</div>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password"
                           class="form-control"
                           name="password_confirmation"
                           required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Create Account
                </button>

                <div class="footer-text">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>

function togglePassword() {
    let input = document.getElementById("password");
    let icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.classList = "bi bi-eye-slash";
    } else {
        input.type = "password";
        icon.classList = "bi bi-eye";
    }
}

function checkPassword(value) {

    updateRule("rule-length", value.length >= 8, "At least 8 characters");
    updateRule("rule-upper", /[A-Z]/.test(value), "One uppercase letter");
    updateRule("rule-lower", /[a-z]/.test(value), "One lowercase letter");
    updateRule("rule-number", /[0-9]/.test(value), "One number");
    updateRule("rule-special", /[@$!%*?&]/.test(value), "One special character");

}

function updateRule(id, condition, text) {
    let el = document.getElementById(id);

    if (condition) {
        el.classList.remove("text-danger");
        el.classList.add("text-success");
        el.innerHTML = "✔ " + text;
    } else {
        el.classList.remove("text-success");
        el.classList.add("text-danger");
        el.innerHTML = "✖ " + text;
    }
}

</script>
@endpush