<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Online Ticket System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body { height:100%; margin:0; padding:0; overflow-x:hidden; }
        body { min-height:100vh; }
        /* Remove container padding so sidebar sits flush to viewport */
        .container-fluid { padding-left:0; padding-right:0; }
        /* Sidebar styling */
        .sidebar { min-height:100vh; background: linear-gradient(180deg,#17232b 0%, #203040 100%); color:#fff; }
        .sidebar .brand { padding:18px 20px; font-weight:800; background:linear-gradient(90deg,#0f1a21,#18232b); color:#fff; }
        .sidebar .nav-link { color: rgba(255,255,255,0.85); padding:12px 18px; display:flex; align-items:center; gap:10px; border-radius:6px; margin:6px 10px; transition: all .15s ease; }
        .sidebar .nav-link i { font-size:1.05rem; width:22px; text-align:center; color:rgba(255,255,255,0.7); }
        .sidebar .nav-link:hover { transform: translateX(4px); background: rgba(255,255,255,0.03); color:#fff; text-decoration:none; }
        .sidebar .nav-link.active { background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)); color:#fff; box-shadow: inset 2px 0 0 0 rgba(255,255,255,0.06); }
        .sidebar .nav-link .badge { margin-left:auto; }
        @media (max-width:991.98px){ .sidebar { position:relative; min-height:auto } }

        /* Offcanvas / mobile sidebar fixes */
        .offcanvas.sidebar-offcanvas { width: 270px; left:0; top:0; height:100vh; }
        .offcanvas.sidebar-offcanvas .offcanvas-body { padding: 0; background: linear-gradient(180deg,#17232b,#203040); color:#fff; min-height:100vh; }
        .offcanvas.sidebar-offcanvas .brand { background:linear-gradient(90deg,#0f1a21,#18232b); color:#cfe2ff; }
        .offcanvas.sidebar-offcanvas .nav-link { color: rgba(255,255,255,0.9); padding:12px 18px; display:flex; align-items:center; gap:10px; border-radius:6px; margin:6px 10px; }
        .offcanvas.sidebar-offcanvas .nav-link:hover { background: rgba(255,255,255,0.03); }
    </style>
    @stack('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        @auth
            <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarCanvas">☰</button>
        @endauth

        <div class="ms-auto">
            @guest
                <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Login</a>
            @else
                <div class="dropdown d-inline">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=17232b&color=fff&rounded=true&size=32" class="rounded-circle me-2" width="32" height="32" alt="avatar">
                        <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:220px;">
                        <li class="px-3 py-2">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d6efd&color=fff&rounded=true&size=48" class="rounded-circle me-2" width="48" height="48" alt="avatar">
                                <div>
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <div class="small text-muted">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                      
                
                        <li>
                            <a href="#" class="dropdown-item text-danger d-flex align-items-center" id="logoutBtn"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
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
                <div class="brand">Online Ticket System</div>
                <nav class="nav flex-column p-2">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/home') }}"><i class="bi bi-speedometer2"></i> Overview</a>
                    <a class="nav-link {{ request()->is('agent/tickets') ? 'active' : '' }}" href="{{ url('/agent/tickets') }}"><i class="bi bi-list-check"></i> Open</a>
                    <a class="nav-link {{ request()->is('*status=Resolved*') ? 'active' : '' }}" href="{{ url('/agent/tickets?status=Resolved') }}"><i class="bi bi-check2-square"></i> Solved</a>

                </nav>
            </div>

            <!-- Offcanvas for mobile -->
            <div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="sidebarCanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ url('/home') }}"><i class="bi bi-speedometer2"></i> Tickets list</a>
                        <a class="nav-link" href="{{ url('/agent/tickets') }}"><i class="bi bi-list-check"></i> Open</a>

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
<!-- SweetAlert2 for global alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Global SweetAlert2 triggers using session flashes and validation errors
    (function(){
        // Success message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: {!! json_encode(session('success')) !!},
                timer: 3500
            });
        @endif

        // Error message
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: {!! json_encode(session('error')) !!}
            });
        @endif

        // Validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Validation errors',
                html: ('<ul style="text-align:left;">' +
                    {!! json_encode(implode('', $errors->all('<li>:message</li>'))) !!} +
                    '</ul>'),
                width: 600
            });
        @endif
    })();
</script>
<script>
    // Logout confirmation using SweetAlert2
    document.addEventListener('click', function (e) {
        var target = e.target;
        // handle clicks on logout link or its children
        if (target && (target.id === 'logoutBtn' || target.closest('#logoutBtn'))) {
            e.preventDefault();
            Swal.fire({
                title: 'Logout',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then(function(result){
                if (result.isConfirmed) {
                    var form = document.getElementById('logout-form');
                    if (form) form.submit();
                }
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>
