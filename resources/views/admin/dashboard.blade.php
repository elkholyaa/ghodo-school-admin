@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('messages.dashboard') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if($userRole === 'admin')
            {{-- Admin Dashboard - Shows all system data --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    {{-- Total Users Widget --}}
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $usersCount }}</h3>
                            <p>{{ __('messages.total_users') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        @can('viewAny', App\Models\User::class)
                            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                                {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <span class="small-box-footer">{{ __('messages.more_info') }}</span>
                        @endcan
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    {{-- Pending Maintenance Requests Widget --}}
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingMaintenanceCount }}</h3>
                            <p>{{ __('messages.pending_maintenance_requests') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    {{-- Pending Material Requests Widget --}}
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pendingMaterialCount }}</h3>
                            <p>{{ __('messages.pending_material_requests') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    {{-- System Status Widget --}}
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ __('messages.admin') }}</h3>
                            <p>{{ __('messages.system_overview') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <span class="small-box-footer">{{ __('messages.admin_access') }}</span>
                    </div>
                </div>
            </div>
        @else
            {{-- Staff Dashboard - Shows only user's own data --}}
            <div class="row">
                <div class="col-lg-6 col-12">
                    {{-- User's Pending Maintenance Requests --}}
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $userPendingMaintenanceCount }}</h3>
                            <p>{{ __('messages.my_pending_maintenance_requests') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6 col-12">
                    {{-- User's Pending Material Requests --}}
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $userPendingMaterialCount }}</h3>
                            <p>{{ __('messages.my_pending_material_requests') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Staff Info Section --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.staff_info') }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ __('messages.welcome_staff') }} <strong>{{ auth()->user()->name }}</strong></p>
                            <p>{{ __('messages.staff_dashboard_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection 