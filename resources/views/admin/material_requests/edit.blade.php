{{--
    Material Requests Edit View
    
    This view provides a form for editing existing material requests with:
    - Pre-filled form data from the existing request
    - Policy-based field restrictions (e.g., staff can only edit pending requests)
    - Optional linking to existing maintenance requests
    - AdminLTE form styling with Arabic RTL support
    
    Educational Note: This demonstrates form pre-population, conditional field access
    based on user policies, and proper handling of existing model data.
--}}

@extends('layouts.admin')

@section('title', __('messages.Edit Material Request'))

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.Edit Material Request') }} #{{ $materialRequest->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.material-requests.index') }}">{{ __('messages.Material Requests') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Edit Material Request Details') }}</h3>
                        </div>
                        
                        <form action="{{ route('admin.material-requests.update', $materialRequest) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                <!-- Item Description -->
                                <div class="form-group">
                                    <label for="item_description">{{ __('messages.Item Description') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('item_description') is-invalid @enderror" 
                                           id="item_description" 
                                           name="item_description" 
                                           value="{{ old('item_description', $materialRequest->item_description) }}" 
                                           placeholder="{{ __('messages.Enter item description') }}"
                                           maxlength="255" 
                                           required>
                                    @error('item_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="form-group">
                                    <label for="quantity">{{ __('messages.Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="{{ old('quantity', $materialRequest->quantity) }}" 
                                           min="1" 
                                           required>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Cost (Optional) -->
                                <div class="form-group">
                                    <label for="cost">{{ __('messages.Cost') }} ({{ __('messages.Optional') }})</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" 
                                               class="form-control @error('cost') is-invalid @enderror" 
                                               id="cost" 
                                               name="cost" 
                                               value="{{ old('cost', $materialRequest->cost) }}" 
                                               step="0.01" 
                                               min="0"
                                               placeholder="0.00">
                                        @error('cost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Funding Source (Optional) -->
                                <div class="form-group">
                                    <label for="funding_source">{{ __('messages.Funding Source') }} ({{ __('messages.Optional') }})</label>
                                    <select class="form-control @error('funding_source') is-invalid @enderror" 
                                            id="funding_source" 
                                            name="funding_source">
                                        <option value="">{{ __('messages.Select funding source') }}</option>
                                        @foreach($fundingSources as $value => $label)
                                            <option value="{{ $value }}" 
                                                    {{ old('funding_source', $materialRequest->funding_source) == $value ? 'selected' : '' }}>
                                                {{ __('messages.' . $label) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('funding_source')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Status (Admin can edit all, Staff only if pending) -->
                                <div class="form-group">
                                    <label for="status">{{ __('messages.Status') }} <span class="text-danger">*</span></label>
                                    @can('update', $materialRequest)
                                        @if(auth()->user()->isAdmin() || $materialRequest->status === 'pending')
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                @foreach($statuses as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ old('status', $materialRequest->status) == $value ? 'selected' : '' }}>
                                                        {{ __('messages.' . $label) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control" 
                                                   value="{{ __('messages.' . ucfirst($materialRequest->status)) }}" 
                                                   readonly>
                                            <input type="hidden" name="status" value="{{ $materialRequest->status }}">
                                            <small class="form-text text-muted">
                                                {{ __('messages.Status cannot be changed once approved/rejected/fulfilled') }}
                                            </small>
                                        @endif
                                    @else
                                        <input type="text" class="form-control" 
                                               value="{{ __('messages.' . ucfirst($materialRequest->status)) }}" 
                                               readonly>
                                        <input type="hidden" name="status" value="{{ $materialRequest->status }}">
                                    @endcan
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Maintenance Request (Optional) -->
                                <div class="form-group">
                                    <label for="maintenance_request_id">{{ __('messages.Link to Maintenance Request') }} ({{ __('messages.Optional') }})</label>
                                    <select class="form-control @error('maintenance_request_id') is-invalid @enderror" 
                                            id="maintenance_request_id" 
                                            name="maintenance_request_id">
                                        <option value="">{{ __('messages.No maintenance request (standalone)') }}</option>
                                        @foreach($openMaintenanceRequests as $maintenanceRequest)
                                            <option value="{{ $maintenanceRequest->id }}" 
                                                    {{ old('maintenance_request_id', $materialRequest->maintenance_request_id) == $maintenanceRequest->id ? 'selected' : '' }}>
                                                #{{ $maintenanceRequest->id }} - {{ $maintenanceRequest->title }}
                                                ({{ $maintenanceRequest->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('maintenance_request_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('messages.Link this request to an existing maintenance request if related') }}
                                    </small>
                                </div>
                            </div>

                            <div class="card-footer">
                                @can('update', $materialRequest)
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save"></i> {{ __('messages.Update Request') }}
                                    </button>
                                @endcan
                                <a href="{{ route('admin.material-requests.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('messages.Back to List') }}
                                </a>
                                @can('view', $materialRequest)
                                    <a href="{{ route('admin.material-requests.show', $materialRequest) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> {{ __('messages.View Details') }}
                                    </a>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info/Status Column -->
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Request Information') }}</h3>
                        </div>
                        <div class="card-body">
                            <h5>{{ __('messages.Current Status') }}</h5>
                            <p>
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
                            </p>

                            <h5>{{ __('messages.Request Details') }}</h5>
                            <ul class="list-unstyled">
                                <li><strong>{{ __('messages.Created') }}:</strong> {{ $materialRequest->created_at->format('Y-m-d H:i') }}</li>
                                <li><strong>{{ __('messages.Requester') }}:</strong> {{ $materialRequest->requester->name }}</li>
                                @if($materialRequest->maintenanceRequest)
                                    <li><strong>{{ __('messages.Linked to') }}:</strong> 
                                        <a href="{{ route('admin.maintenance-requests.show', $materialRequest->maintenanceRequest) }}">
                                            {{ __('messages.Maintenance Request') }} #{{ $materialRequest->maintenanceRequest->id }}
                                        </a>
                                    </li>
                                @endif
                            </ul>

                            @if(!auth()->user()->isAdmin() && $materialRequest->status !== 'pending')
                                <div class="alert alert-warning">
                                    <h6><i class="icon fas fa-exclamation-triangle"></i> {{ __('messages.Note') }}</h6>
                                    {{ __('messages.You can only edit requests with pending status') }}
                                </div>
                            @endif

                            @if($materialRequest->status === 'pending')
                                <div class="alert alert-info">
                                    <h6><i class="icon fas fa-info"></i> {{ __('messages.Tip') }}</h6>
                                    {{ __('messages.This request can still be modified since it is pending approval') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 