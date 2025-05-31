<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        /* Override for RTL fixes */
        body {
            text-align: right;
        }
        body:not(.layout-fixed) .main-sidebar {
            right: 0;
        }
        .navbar-nav {
            padding-right: 0;
        }
        .content-wrapper, .main-footer, .main-header {
            margin-right: 250px;
            margin-left: 0;
        }
        @media (max-width: 991.98px) {
            .content-wrapper, .main-footer, .main-header {
                margin-right: 0;
            }
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, 
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, 
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
                margin-right: 0 !important;
            }
        }
        .navbar-nav.ml-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }
        .text-right {
            text-align: left !important;
        }
        .text-left {
            text-align: right !important;
        }
        
        /* Fix for sidebar text alignment */
        .nav-sidebar>.nav-item {
            text-align: right;
        }
        .nav-sidebar .nav-link p {
            text-align: right;
        }
        .nav-sidebar .nav-icon {
            margin-left: 0.2rem;
            margin-right: -0.2rem;
        }
        
        /* Dashboard content alignment */
        .container-fluid h1, 
        .container-fluid .h1,
        .container-fluid p,
        .breadcrumb-item,
        .small-box-footer,
        .small-box p {
            text-align: right;
        }
        
        /* Fix icon positioning */
        .small-box-footer i,
        .nav-link i {
            margin-left: 5px;
            margin-right: 0;
        }
        .small-box .icon {
            right: auto;
            left: 10px;
        }
        
        /* Responsive improvements */
        @media (max-width: 767.98px) {
            .brand-text {
                font-size: 1rem;
            }
            
            .dropdown-menu-lg {
                width: 250px;
            }
            
            .nav-link {
                padding: 0.5rem 0.75rem;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">{{ __('messages.dashboard') }}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication -->
                @auth
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->email }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">{{ __('messages.profile') }}</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-default btn-flat float-right">{{ __('messages.logout') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                </li>
                @endif
                @endauth
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">{{ __('مدرسة غدو - لوحة التحكم') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @auth
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>{{ __('messages.dashboard') }}</p>
                            </a>
                        </li>
                        @can('viewAny', App\Models\User::class)
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>{{ __('messages.user_management') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny', App\Models\MaintenanceRequest::class)
                        <li class="nav-item">
                            <a href="{{ route('admin.maintenance-requests.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>{{ __('messages.maintenance_requests') }}</p>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny', App\Models\MaterialRequest::class)
                        <li class="nav-item">
                            <a href="{{ route('admin.material-requests.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>{{ __('messages.material_requests') }}</p>
                            </a>
                        </li>
                        @endcan
                        @endauth
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <!-- Flash messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show">
                            {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <strong>{{ __('messages.copyright') }} &copy; {{ date('Y') }} <a href="#">{{ config('app.name', 'Ghodo School Admin') }}</a>.</strong>
            <span class="d-none d-md-inline">{{ __('messages.all_rights_reserved') }}</span>
            <div class="float-left d-none d-sm-inline-block">
                <b>{{ __('messages.version') }}</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Additional JavaScript -->
    @vite([
        'resources/backend/adminlte/dist/adminlte.min.js',
        'resources/backend/adminlte/dist/bootstrap.bundle.min.js',
    ])

    <!-- Stack for page-specific scripts -->
    @stack('scripts')
    
    <!-- Initialize Bootstrap components -->
    <script>
        $(document).ready(function() {
            // Initialize dropdowns
            $('.dropdown-toggle').dropdown();
            
            // Make dropdown work on hover for desktop
            $('.dropdown').hover(
                function() { 
                    if (window.innerWidth >= 768) {
                        $('.dropdown-toggle', this).trigger('click'); 
                    }
                }
            );
            
            // Fix burger menu toggle
            $('[data-widget="pushmenu"]').on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('sidebar-collapse');
                $('body').toggleClass('sidebar-open');
            });
            
            // Make dashboard boxes clickable
            $('.info-box, .small-box').css('cursor', 'pointer').on('click', function() {
                var $infoBtn = $(this).find('.info-box-content a, .small-box-footer');
                if ($infoBtn.length) {
                    window.location = $infoBtn.attr('href');
                } else {
                    alert('{{ __("messages.feature_coming_soon") }}');
                }
            });
            
            // Add touch-friendly behavior for mobile
            if (window.innerWidth < 768) {
                $('.dropdown-toggle').on('click', function(e) {
                    e.preventDefault();
                    $(this).dropdown('toggle');
                });
            }
        });
    </script>
</body>
</html> 