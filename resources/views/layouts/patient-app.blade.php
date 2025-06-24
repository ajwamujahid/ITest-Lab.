<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient | @yield('title')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Select2 CSS (if used) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Page-specific styles (optional, from child views) -->
@stack('styles')

    <style>
        body {
            background-color: #e9f0f7;
        }
        .auth-card {
            max-width: 420px;
            margin: 60px auto;
            padding: 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .auth-card h3 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #234;
        }
        .footer {
            font-size: 0.85rem;
            color: #888;
            text-align: center;
            margin-top: 40px;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- <div class="container">
        <div class="auth-card">
            {{-- Page Title --}}
            {{-- <h3 class="text-center">@yield('title')</h3> --}}

            {{-- Main Auth Form --}}
            @yield('content')
        {{-- </div> --}}

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} Patient Portal. All rights reserved.
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <!-- jQuery (required for Select2) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Bootstrap JS Bundle (includes modal + popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 JS (if using select2 dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Page-specific scripts -->
@stack('scripts')

</body>
</html>
