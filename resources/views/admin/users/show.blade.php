@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('User Details') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Details') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $user->name }} - {{ __('Details') }}</h3>
                        <div class="card-tools">
                            @can('update', $user)
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                            @endcan
                            
                            @can('delete', $user)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Name') }}:</label>
                                    <p class="form-control-static">{{ $user->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Email Address') }}:</label>
                                    <p class="form-control-static">{{ $user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Role') }}:</label>
                                    <p class="form-control-static">
                                        <span class="badge {{ $user->isAdmin() ? 'badge-danger' : 'badge-info' }}">
                                            {{ $user->role }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Phone Number') }}:</label>
                                    <p class="form-control-static">
                                        {{ $user->phone ?: __('Not specified') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Civil ID') }}:</label>
                                    <p class="form-control-static">
                                        {{ $user->civil_id ?: __('Not specified') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Created At') }}:</label>
                                    <p class="form-control-static">
                                        {{ $user->created_at->format('Y-m-d H:i:s') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Users List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 