@extends('layouts.app')

@push('head')
<style>
    body {
        background: linear-gradient(135deg, #eef2f7, #f8fafc);
        overflow: hidden;
        position: relative;
    }

    /* Floating background animation */
    body::before {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(37, 99, 235, 0.08);
        border-radius: 50%;
        top: -80px;
        left: -80px;
        animation: float 6s ease-in-out infinite;
    }

    body::after {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        background: rgba(16, 185, 129, 0.08);
        border-radius: 50%;
        bottom: -80px;
        right: -80px;
        animation: float2 7s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(30px); }
    }

    @keyframes float2 {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-30px); }
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    /* Card animation */
    .login-card {
        width: 100%;
        max-width: 420px;
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.08);
        overflow: hidden;
        background: #fff;

        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        background: linear-gradient(135deg, #1f2937, #111827);
        color: #fff;
        padding: 22px;
        text-align: center;
    }

    .login-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .badge-role {
        background: #10b981;
        color: #fff;
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 6px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
        70% { box-shadow: 0 0 0 10px rgba(16,185,129,0); }
        100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
    }

    .login-body {
        padding: 28px;
    }

    .form-control {
        border-radius: 10px;
        padding: 11px;
        border: 1px solid #e5e7eb;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        transform: scale(1.02);
    }

    .btn-login {
        background: #2563eb;
        border: none;
        border-radius: 10px;
        padding: 11px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .btn-login:active {
        transform: scale(0.98);
    }

    .btn-register {
        border-radius: 10px;
        width: 100%;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-register:hover {
        transform: translateY(-2px);
    }

</style>
@endpush

@section('content')
<div class="login-wrapper">

    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <h4>Support Agent Portal</h4>
            <span class="badge-role">Secure Login</span>
        </div>

        <!-- BODY -->
        <div class="login-body">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Agent Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="agent@company.com"
                           required autofocus>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter secure password"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    Sign In
                </button>

                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-register">
                    Create Agent Account
                </a>

            </form>

        </div>
    </div>

</div>
@endsection