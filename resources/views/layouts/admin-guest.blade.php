<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ghodo School Admin') }}</title>

    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/app_admin.css',
        'resources/js/app_admin.js',
        'resources/backend/adminlte/dist/adminlte.min.css',
        'resources/backend/adminlte/dist/bootstrap.min.css',
        'resources/backend/adminlte/dist/all.min.css',
    ])
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>مدرسة غدو</b> - لوحة التحكم</a>
        </div>
        
        @yield('content')
        
        <div class="text-center mt-3">
            <p>{{ __('Copyright') }} &copy; {{ date('Y') }} <a href="#">{{ config('app.name', 'Ghodo School Admin') }}</a></p>
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