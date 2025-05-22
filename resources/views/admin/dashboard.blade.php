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
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ \App\Models\User::count() }}</h3>
                        <p>{{ __('messages.users') }}</p>
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
            
            <!-- Additional widgets will be added here for maintenance requests and material requests -->
        </div>
    </div>
</section>
@endsection 