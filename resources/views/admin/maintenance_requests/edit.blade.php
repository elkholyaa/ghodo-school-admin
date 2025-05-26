@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('messages.edit_maintenance_request') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.maintenance-requests.index') }}">{{ __('messages.maintenance_requests') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.edit') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.edit_maintenance_request_details') }}</h3>
                    </div>
                    
                    <form action="{{ route('admin.maintenance-requests.update', $maintenanceRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            
                            <div class="form-group">
                                <label for="title">{{ __('messages.title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $maintenanceRequest->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="floor">{{ __('messages.floor') }}</label>
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor', $maintenanceRequest->floor) }}">
                                @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="location">{{ __('messages.location') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $maintenanceRequest->location) }}" required>
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="description">{{ __('messages.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $maintenanceRequest->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="priority">{{ __('messages.priority') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    @foreach ($priorities as $value => $label)
                                    <option value="{{ $value }}" {{ old('priority', $maintenanceRequest->priority) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="status">{{ __('messages.status') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required 
                                        {{ !auth()->user()->isAdmin() && $maintenanceRequest->status != 'new' ? 'disabled' : '' }}>
                                    @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $maintenanceRequest->status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if (!auth()->user()->isAdmin() && $maintenanceRequest->status != 'new')
                                <small class="text-muted">{{ __('messages.status_locked_staff') }}</small>
                                <!-- Hidden input to ensure the original value is submitted when field is disabled -->
                                <input type="hidden" name="status" value="{{ $maintenanceRequest->status }}">
                                @endif
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('messages.update_request') }}</button>
                            <a href="{{ route('admin.maintenance-requests.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                            
                            @can('view', $maintenanceRequest)
                            <a href="{{ route('admin.maintenance-requests.show', $maintenanceRequest) }}" class="btn btn-info float-right">
                                <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                            </a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.request_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <h5>{{ __('messages.current_status') }}</h5>
                        <p>
                            @switch($maintenanceRequest->status)
                                @case('new')
                                    <span class="badge badge-primary">{{ __('messages.new') }}</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge badge-warning">{{ __('messages.in_progress') }}</span>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success">{{ __('messages.completed') }}</span>
                                    @break
                                @case('transferred')
                                    <span class="badge badge-secondary">{{ __('messages.transferred') }}</span>
                                    @break
                            @endswitch
                        </p>
                        
                        <h5>{{ __('messages.request_details') }}</h5>
                        <ul>
                            <li><strong>{{ __('messages.created') }}:</strong> {{ $maintenanceRequest->created_at->format('Y-m-d H:i') }}</li>
                            <li><strong>{{ __('messages.requester') }}:</strong> {{ $maintenanceRequest->requester->name }}</li>
                            <li><strong>{{ __('messages.id') }}:</strong> #{{ $maintenanceRequest->id }}</li>
                        </ul>
                        
                        @if(!auth()->user()->isAdmin() && $maintenanceRequest->status != 'new')
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle mr-1"></i> {{ __('messages.staff_can_only_edit_new') }}
                        </div>
                        @else
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-1"></i> {{ __('messages.edit_tip') }}
                        </div>
                        @endif
                        
                        @if($maintenanceRequest->materialRequests->count() > 0)
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-boxes mr-1"></i> {{ __('messages.has_material_requests', ['count' => $maintenanceRequest->materialRequests->count()]) }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 