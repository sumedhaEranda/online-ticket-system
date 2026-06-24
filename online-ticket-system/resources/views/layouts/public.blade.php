<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Ticket Status')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#fff;margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial;}
    .container{max-width:760px}
  </style>
  @stack('head')
</head>
<body>
  <main class="container py-5">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    (function(){
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Success', text: {!! json_encode(session('success')) !!}, timer: 3500 });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Error', text: {!! json_encode(session('error')) !!} });
        @endif

        @if ($errors->any())
            Swal.fire({ icon: 'warning', title: 'Validation errors', html: ('<ul style="text-align:left;">' + {!! json_encode(implode('', $errors->all('<li>:message</li>'))) !!} + '</ul>'), width: 600 });
        @endif
    })();
  </script>

  @stack('scripts')
</body>
</html>