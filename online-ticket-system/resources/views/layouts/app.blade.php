<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Online Ticket System')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- add bootstrap icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @stack('head')
</head>
<body>
<nav class="navbar navbar-light bg-white border-bottom" style="height:56px">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary d-lg-none" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Open menu">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand mb-0 h5 ms-2" href="{{ url('/') }}" aria-label="{{ config('app.name','') }}"></a>
    </div>

    <div class="ms-auto">
      @guest
        <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>
      @else
        <div class="dropdown">
          <button class="btn btn-sm d-flex align-items-center gap-2" id="userDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="user-avatar rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center">
              {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </span>
            <span class="d-none d-md-inline fw-medium">{{ auth()->user()->name }}</span>
            <i class="bi bi-chevron-down ms-1"></i>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow-lg py-2" aria-labelledby="userDropdown">
            <li class="px-3 py-2">
              <div class="d-flex align-items-center">
                <div class="user-avatar rounded-circle bg-primary text-white d-inline-flex justify-content-center align-items-center me-2">
                  {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                  <div class="fw-bold small mb-0">{{ auth()->user()->name }}</div>
                  <div class="text-muted small">{{ auth()->user()->email }}</div>
                </div>
              </div>
            </li>
            <li class="px-3">
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
              </form>
            </li>
          </ul>
        </div>
      @endguest
    </div>
  </div>
</nav>

<!-- Desktop sidebar -->
<aside id="appSidebar" class="sidebar d-none d-lg-block">
  <div class="brand">
    <div class="logo">OT</div>
    <div class="brand-text">
      <div>Online</div>
      <div style="font-size:.85rem;color:var(--text-muted)">TicketSystem</div>
    </div>

    <button id="toggleSidebar" class="collapse-toggle" title="Toggle sidebar" aria-label="Toggle sidebar">
      <i class="bi bi-chevron-left"></i>
    </button>
  </div>

  @auth
  <div class="user">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
    <div class="meta">
      <div class="name">{{ auth()->user()->name }}</div>
      <div class="email">{{ auth()->user()->email }}</div>
    </div>
  </div>
  @endauth

  <nav class="nav flex-column px-2">
    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}">
      <i class="bi bi-speedometer2"></i><span class="label">Overview</span>
    </a>

    <a class="nav-link {{ request()->is('agent/tickets*') && request()->get('status') == 'Open' ? 'active' : '' }}" href="{{ url('/agent/tickets') }}#open">
      <i class="bi bi-journal-text"></i><span class="label">Open</span>
    </a>
  </nav>
</aside>

<!-- Mobile offcanvas -->
<div class="offcanvas offcanvas-start" id="mobileSidebar" tabindex="-1" aria-labelledby="mobileSidebarLabel">
  <div class="offcanvas-header" style="background:var(--sidebar-accent); color:var(--link-color);">
    <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0" style="background:var(--sidebar-bg);min-height:100vh">
    <div class="brand px-3 py-2 d-flex align-items-center">
      <div class="logo me-2">OT</div>
      <div class="brand-text">TicketSystem</div>
    </div>
    <nav class="nav flex-column px-2 mt-2">
      <a class="nav-link" href="{{ url('/home') }}"><i class="bi bi-speedometer2 me-2"></i><span>Overview</span></a>
      <a class="nav-link" href="{{ url('/agent/tickets') }}#open"><i class="bi bi-journal-text me-2"></i><span>Open</span></a>
    </nav>
  </div>
</div>

<!-- Main content -->
<div class="main-wrapper">
  @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@stack('scripts')
</body>
</html>
