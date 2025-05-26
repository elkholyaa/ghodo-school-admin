@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('messages.create_maintenance_request') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.maintenance-requests.index') }}">{{ __('messages.maintenance_requests') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.create') }}</li>
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
                        <h3 class="card-title">{{ __('messages.maintenance_request_details') }}</h3>
                    </div>
                    
                    <form action="{{ route('admin.maintenance-requests.store') }}" method="POST">
                        @csrf
                        
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
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="floor">{{ __('messages.floor') }}</label>
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor') }}">
                                @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="location">{{ __('messages.location') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="description">{{ __('messages.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="priority">{{ __('messages.priority') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    @foreach ($priorities as $value => $label)
                                    <option value="{{ $value }}" {{ old('priority', 'normal') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="status">{{ __('messages.status') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', 'new') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('messages.create_request') }}</button>
                            <a href="{{ route('admin.maintenance-requests.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.help_and_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <h5>{{ __('messages.required_fields') }}</h5>
                        <ul>
                            <li><strong>{{ __('messages.title') }}:</strong> {{ __('messages.brief_title') }}</li>
                            <li><strong>{{ __('messages.location') }}:</strong> {{ __('messages.specific_location') }}</li>
                            <li><strong>{{ __('messages.priority') }}:</strong> {{ __('messages.priority_explanation') }}</li>
                            <li><strong>{{ __('messages.status') }}:</strong> {{ __('messages.status_explanation') }}</li>
                        </ul>
                        
                        <h5>{{ __('messages.optional_fields') }}</h5>
                        <ul>
                            <li><strong>{{ __('messages.floor') }}:</strong> {{ __('messages.floor_explanation') }}</li>
                            <li><strong>{{ __('messages.description') }}:</strong> {{ __('messages.description_explanation') }}</li>
                        </ul>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-1"></i> {{ __('messages.create_note') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 