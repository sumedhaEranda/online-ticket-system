<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Online Ticket System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh; }
        .sidebar { min-height:100vh; background:#1f2d3d; color:#fff; }
        .sidebar a { color:#cfe2ff; text-decoration:none; display:block; padding:10px 16px; }
        .sidebar a:hover { background:rgba(255,255,255,0.03); color:#fff; }
        .brand { padding:12px 16px; font-weight:700; background:#18232b; }
        @media (max-width:991.98px){ .sidebar { position:relative; min-height:auto } }

        /* Offcanvas / mobile sidebar fixes */
        .offcanvas.sidebar-offcanvas { width: 260px; }
        .offcanvas.sidebar-offcanvas .offcanvas-body { padding: 0; background:#1f2d3d; color:#fff; min-height:100vh; }
        .offcanvas.sidebar-offcanvas .brand { background:#18232b; color:#cfe2ff; }
        .offcanvas.sidebar-offcanvas a { color:#cfe2ff; text-decoration:none; display:block; padding:10px 16px; }
        .offcanvas.sidebar-offcanvas a:hover { background:rgba(255,255,255,0.03); color:#fff; }
    </style>
    @stack('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        @auth
            <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas">☰</button>
        @endauth

        <a class="navbar-brand ms-2" href="{{ url('/') }}">Online TicketSystem</a>

        <div class="ms-auto">
            @guest
                <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>
            @else
                <div class="dropdown d-inline">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-2">
                                @csrf
                                <button class="btn btn-link">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row g-0">
        @auth
            <div class="col-lg-2 d-none d-lg-block sidebar">
                <div class="brand">Dashboard</div>
                <a href="{{ url('/home') }}">Overview</a>
                <a href="{{ url('/agent/tickets') }}">Open</a>
                <a href="#">Solved</a>
                <a href="#">Closed</a>
                <a href="#">Pending</a>
            </div>

            <!-- Offcanvas for mobile -->
            <div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="sidebarCanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="brand">Dashboard</div>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ url('/home') }}">Tickets list </a>
                        <a class="nav-link" href="{{ url('/agent/tickets') }}">Open</a>
                        <a class="nav-link" href="#">Solved</a>
                        <a class="nav-link" href="#">Closed</a>
                        <a class="nav-link" href="#">Pending</a>
                    </nav>
                </div>
            </div>

            <main class="col-lg-10 p-3">
                @yield('content')
            </main>
        @else
            <main class="col-12 p-3">
                @yield('content')
            </main>
        @endauth
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@stack('scripts')
</body>
</html>
