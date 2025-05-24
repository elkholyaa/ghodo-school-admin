{{--
    Material Requests Show View
    
    This view displays detailed information about a single material request:
    - All request details in a read-only format
    - Related maintenance request information
    - Status history and timestamps
    - Action buttons based on user permissions
    
    Educational Note: This demonstrates read-only data display, relationship data presentation,
    and conditional action buttons based on authorization policies.
--}}

@extends('layouts.admin')

@section('title', __('messages.Material Request Details'))

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.Material Request Details') }} #{{ $materialRequest->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.material-requests.index') }}">{{ __('messages.Material Requests') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Details') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Details Card -->
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Request Information') }}</h3>
                            <div class="card-tools">
                                @switch($materialRequest->status)
                                    @case('pending')
                                        <span class="badge badge-warning badge-lg">{{ __('messages.Pending') }}</span>
                                        @break
                                    @case('approved')
                                        <span class="badge badge-success badge-lg">{{ __('messages.Approved') }}</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge badge-danger badge-lg">{{ __('messages.Rejected') }}</span>
                                        @break
                                    @case('fulfilled')
                                        <span class="badge badge-info badge-lg">{{ __('messages.Fulfilled') }}</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Item Description') }}:</strong>
                                    <p class="text-muted">{{ $materialRequest->item_description }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Quantity') }}:</strong>
                                    <p class="text-muted">{{ $materialRequest->quantity }} {{ __('messages.items') }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Cost') }}:</strong>
                                    <p class="text-muted">
                                        @if($materialRequest->cost)
                                            ${{ number_format($materialRequest->cost, 2) }}
                                        @else
                                            <em>{{ __('messages.Not specified') }}</em>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Funding Source') }}:</strong>
                                    <p class="text-muted">
                                        @if($materialRequest->funding_source)
                                            @switch($materialRequest->funding_source)
                                                @case('school_budget')
                                                    {{ __('messages.School Budget') }}
                                                    @break
                                                @case('maintenance')
                                                    {{ __('messages.Maintenance') }}
                                                    @break
                                                @case('other')
                                                    {{ __('messages.Other') }}
                                                    @break
                                                @default
                                                    {{ ucfirst($materialRequest->funding_source) }}
                                            @endswitch
                                        @else
                                            <em>{{ __('messages.Not specified') }}</em>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Status') }}:</strong>
                                    <p class="text-muted">
                                        @switch($materialRequest->status)
                                            @case('pending')
                                                <span class="badge badge-warning">{{ __('messages.Pending') }}</span>
                                                @break
                                            @case('approved')
                                                <span class="badge badge-success">{{ __('messages.Approved') }}</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge badge-danger">{{ __('messages.Rejected') }}</span>
                                                @break
                                            @case('fulfilled')
                                                <span class="badge badge-info">{{ __('messages.Fulfilled') }}</span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.Requester') }}:</strong>
                                    <p class="text-muted">{{ $materialRequest->requester->name }}</p>
                                </div>
                            </div>

                            @if($materialRequest->maintenanceRequest)
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <strong>{{ __('messages.Linked Maintenance Request') }}:</strong>
                                        <div class="card card-outline card-info mt-2">
                                            <div class="card-body">
                                                <h5>
                                                    <a href="{{ route('admin.maintenance-requests.show', $materialRequest->maintenanceRequest) }}" 
                                                       class="text-primary">
                                                        #{{ $materialRequest->maintenanceRequest->id }} - {{ $materialRequest->maintenanceRequest->title }}
                                                    </a>
                                                </h5>
                                                <p class="text-muted mb-1">
                                                    <i class="fas fa-map-marker-alt"></i> 
                                                    {{ $materialRequest->maintenanceRequest->location }}
                                                    @if($materialRequest->maintenanceRequest->floor)
                                                        - {{ __('messages.Floor') }}: {{ $materialRequest->maintenanceRequest->floor }}
                                                    @endif
                                                </p>
                                                @if($materialRequest->maintenanceRequest->description)
                                                    <p class="text-muted small">{{ Str::limit($materialRequest->maintenanceRequest->description, 150) }}</p>
                                                @endif
                                                <span class="badge badge-secondary">
                                                    {{ ucfirst($materialRequest->maintenanceRequest->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <strong>{{ __('messages.Maintenance Request') }}:</strong>
                                        <p class="text-muted">
                                            <em>{{ __('messages.This is a standalone material request') }}</em>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <div class="btn-group" role="group">
                                @can('update', $materialRequest)
                                    <a href="{{ route('admin.material-requests.edit', $materialRequest) }}" 
                                       class="btn btn-warning">
                                        <i class="fas fa-edit"></i> {{ __('messages.Edit Request') }}
                                    </a>
                                @endcan
                                
                                @can('delete', $materialRequest)
                                    <form action="{{ route('admin.material-requests.destroy', $materialRequest) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('{{ __('messages.Are you sure you want to delete this material request?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> {{ __('messages.Delete Request') }}
                                        </button>
                                    </form>
                                @endcan
                                
                                <a href="{{ route('admin.material-requests.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('messages.Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamps and Metadata -->
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Timestamps') }}</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-5">{{ __('messages.Created') }}:</dt>
                                <dd class="col-sm-7">{{ $materialRequest->created_at->format('Y-m-d H:i') }}</dd>
                                
                                <dt class="col-sm-5">{{ __('messages.Updated') }}:</dt>
                                <dd class="col-sm-7">{{ $materialRequest->updated_at->format('Y-m-d H:i') }}</dd>
                                
                                @if($materialRequest->created_at != $materialRequest->updated_at)
                                    <dt class="col-sm-5">{{ __('messages.Time Since Update') }}:</dt>
                                    <dd class="col-sm-7">{{ $materialRequest->updated_at->diffForHumans() }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Quick Actions') }}</h3>
                        </div>
                        <div class="card-body">
                            @if($materialRequest->maintenanceRequest)
                                <a href="{{ route('admin.maintenance-requests.show', $materialRequest->maintenanceRequest) }}" 
                                   class="btn btn-info btn-block">
                                    <i class="fas fa-tools"></i> {{ __('messages.View Maintenance Request') }}
                                </a>
                            @endif
                            
                            @can('create', App\Models\MaterialRequest::class)
                                <a href="{{ route('admin.material-requests.create') }}" 
                                   class="btn btn-success btn-block">
                                    <i class="fas fa-plus"></i> {{ __('messages.Create New Request') }}
                                </a>
                            @endcan
                            
                            <a href="{{ route('admin.material-requests.index') }}" 
                               class="btn btn-outline-primary btn-block">
                                <i class="fas fa-list"></i> {{ __('messages.All Material Requests') }}
                            </a>
                        </div>
                    </div>

                    <!-- Status Information -->
                    @if($materialRequest->status === 'pending')
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('messages.Status Information') }}</h3>
                            </div>
                            <div class="card-body">
                                <p class="text-warning">
                                    <i class="fas fa-clock"></i> 
                                    {{ __('messages.This request is awaiting approval') }}
                                </p>
                                @can('update', $materialRequest)
                                    <p class="small text-muted">
                                        {{ __('messages.You can still edit this request since it is pending') }}
                                    </p>
                                @endcan
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection 