<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Online Ticket System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card card border-0">
      <div class="card-body">
        <div class="login-header">
          <h2>Welcome Back</h2>
          <p>Sign in to your account</p>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" 
                   value="{{ old('email') }}" required autofocus placeholder="name@example.com">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" 
                   required placeholder="Enter your password">
          </div>

          <div class="checkbox-group">
            <input type="checkbox" id="remember" name="remember" value="on">
            <label for="remember">Remember me</label>
          </div>

          <button type="submit" class="btn-login">Login</button>

          @if (Route::has('password.request'))
            <div class="forgot-link">
              <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
          @endif
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
