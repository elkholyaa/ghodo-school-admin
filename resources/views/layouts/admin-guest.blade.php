<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ghodo School Admin') }}</title>

    <!-- jQuery needs to be loaded before Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/app_admin.css',
        'resources/js/app_admin.js',
        'resources/backend/adminlte/dist/adminlte.min.css',
        'resources/backend/adminlte/dist/bootstrap.min.css',
        'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
    ])
    
    <!-- Additional RTL styles -->
    <style>
        /* RTL fixes for login page */
        body {
            text-align: right;
        }
        .login-box {
            text-align: right;
        }
        .input-group-prepend {
            display: flex;
            margin-left: -1px;
            margin-right: 0;
        }
        .input-group > .input-group-prepend > .input-group-text {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
        .input-group > .form-control:not(:first-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
        .custom-control {
            padding-right: 1.5rem;
            padding-left: 0;
            text-align: right;
        }
        .custom-control-label::before, 
        .custom-control-label::after {
            right: -1.5rem;
            left: auto;
        }
        .text-right {
            text-align: left !important;
        }
        .text-left {
            text-align: right !important;
        }
        .btn i {
            margin-left: 5px;
            margin-right: 0;
        }
        .row {
            display: flex;
            flex-direction: row;
        }
        .col-4, .col-8 {
            float: right;
        }
        .input-group-text {
            position: relative;
            z-index: 2;
        }
        .fa-question-circle {
            margin-left: 5px;
            margin-right: 0;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>مدرسة غدو</b> - لوحة التحكم</a>
        </div>
        
        @yield('content')
        
        <div class="text-center mt-3">
            <p>{{ __('messages.copyright') }} &copy; {{ date('Y') }} <a href="#">{{ config('app.name', 'Ghodo School Admin') }}</a></p>
        </div>
    </div>

    <!-- Additional JavaScript -->
    @vite([
        'resources/backend/adminlte/dist/adminlte.min.js',
        'resources/backend/adminlte/dist/bootstrap.bundle.min.js',
    ])

    <!-- Stack for page-specific scripts -->
    @stack('scripts')
</body>
</html> 