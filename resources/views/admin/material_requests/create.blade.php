{{--
    Material Requests Create View
    
    This view provides a form for creating new material requests with:
    - Optional linking to existing maintenance requests
    - All required and optional fields with proper validation
    - AdminLTE form styling with Arabic RTL support
    
    Educational Note: This demonstrates complex form creation with optional relationships,
    dropdown population from controller data, and Laravel form validation display.
--}}

@extends('layouts.admin')

@section('title', __('messages.Add New Request'))

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.Add New Request') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.material-requests.index') }}">{{ __('messages.Material Requests') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Add New Request') }}</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Material Request Details') }}</h3>
                        </div>
                        
                        <form action="{{ route('admin.material-requests.store') }}" method="POST">
                            @csrf
                            
                            <div class="card-body">
                                <!-- Item Description -->
                                <div class="form-group">
                                    <label for="item_description">{{ __('messages.Item Description') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('item_description') is-invalid @enderror" 
                                           id="item_description" 
                                           name="item_description" 
                                           value="{{ old('item_description') }}" 
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
                                           value="{{ old('quantity', 1) }}" 
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
                                               value="{{ old('cost') }}" 
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
                                            <option value="{{ $value }}" {{ old('funding_source') == $value ? 'selected' : '' }}>
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

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">{{ __('messages.Status') }} <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ old('status', 'pending') == $value ? 'selected' : '' }}>
                                                {{ __('messages.' . $label) }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                                    {{ old('maintenance_request_id') == $maintenanceRequest->id ? 'selected' : '' }}>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('messages.Create Request') }}
                                </button>
                                <a href="{{ route('admin.material-requests.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('messages.Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help/Info Column -->
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.Help & Information') }}</h3>
                        </div>
                        <div class="card-body">
                            <h5>{{ __('messages.Required Fields') }}</h5>
                            <ul>
                                <li>{{ __('messages.Item Description') }} - {{ __('messages.Brief description of the material needed') }}</li>
                                <li>{{ __('messages.Quantity') }} - {{ __('messages.Number of items required') }}</li>
                                <li>{{ __('messages.Status') }} - {{ __('messages.Current status of the request') }}</li>
                            </ul>

                            <h5 class="mt-3">{{ __('messages.Optional Fields') }}</h5>
                            <ul>
                                <li>{{ __('messages.Cost') }} - {{ __('messages.Estimated or actual cost') }}</li>
                                <li>{{ __('messages.Funding Source') }} - {{ __('messages.Where the money will come from') }}</li>
                                <li>{{ __('messages.Maintenance Request') }} - {{ __('messages.Link to related maintenance work') }}</li>
                            </ul>

                            <div class="alert alert-info mt-3">
                                <h6><i class="icon fas fa-info"></i> {{ __('messages.Note') }}</h6>
                                {{ __('messages.You can always edit this request later if the status is still pending') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 