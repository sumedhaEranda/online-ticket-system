<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Online Ticket System')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{--sidebar-bg:#1f2d3d;--sidebar-accent:#18232b;--link-color:#cfe2ff;}
    html,body{height:100%;}
    body{min-height:100vh;background:#f6f7fb;margin:0;}
    .navbar { z-index: 2000; }
    .dropdown-menu { z-index: 3000 !important; }
    .sidebar {
      position:fixed; top:56px; left:0; bottom:0; width:240px;
      background:var(--sidebar-bg); color:#fff; overflow:auto; z-index:1000;
    }
    .sidebar .brand{padding:16px;font-weight:700;background:var(--sidebar-accent);color:var(--link-color)}
    .sidebar .nav-link{color:var(--link-color) !important;padding:12px 18px;text-decoration:none !important}
    .sidebar .nav-link:hover{background:rgba(255,255,255,0.03);color:#fff !important}
    .main-wrapper { margin-top:56px; margin-left:240px; padding:24px; }
    @media (max-width:991.98px){ .sidebar{display:none} .main-wrapper{margin-left:0} }
  </style>
  @stack('head')
</head>
<body>
<nav class="navbar navbar-light bg-white border-bottom" style="height:56px">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">☰</button>
      <a class="navbar-brand mb-0 h5 ms-2" href="{{ url('/') }}">{{ config('app.name','Online TicketSystem') }}</a>
    </div>

    <div class="ms-auto">
      @guest
        <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>
      @else
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                  id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </button>

          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      @endguest
    </div>
  </div>
</nav>

<!-- Desktop sidebar -->
<aside class="sidebar d-none d-lg-block">
  <div class="brand">Dashboard</div>
  <nav class="nav flex-column">
    <a class="nav-link" href="{{ url('/home') }}">Overview</a>
    <a class="nav-link" href="{{ url('/agent/tickets') }}#open">Open</a>
    <a class="nav-link" href="{{ url('/agent/tickets') }}#solved">Solved</a>
    <a class="nav-link" href="{{ url('/agent/tickets') }}#closed">Closed</a>
    <a class="nav-link" href="{{ url('/agent/tickets') }}#pending">Pending</a>
  </nav>
</aside>

<!-- Mobile offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
  <div class="offcanvas-header" style="background:var(--sidebar-accent); color:var(--link-color);">
    <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0" style="background:var(--sidebar-bg);min-height:100vh">
    <div class="brand">Dashboard</div>
    <nav class="nav flex-column">
      <a class="nav-link" href="{{ url('/home') }}">Overview</a>
      <a class="nav-link" href="{{ url('/agent/tickets') }}#open">Open</a>
      <a class="nav-link" href="{{ url('/agent/tickets') }}#solved">Solved</a>
      <a class="nav-link" href="{{ url('/agent/tickets') }}#closed">Closed</a>
      <a class="nav-link" href="{{ url('/agent/tickets') }}#pending">Pending</a>
    </nav>
  </div>
</div>

<div class="main-wrapper">
  @yield('content')
</div>

<!-- At very end of body, before @stack('scripts') -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
