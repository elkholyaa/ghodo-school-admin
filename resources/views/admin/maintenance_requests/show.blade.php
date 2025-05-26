@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('messages.maintenance_request_details') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.maintenance-requests.index') }}">{{ __('messages.maintenance_requests') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.details') }}</li>
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
                        <h3 class="card-title">{{ $maintenanceRequest->title }}</h3>
                        <div class="card-tools">
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

                            @if($maintenanceRequest->priority == 'urgent')
                                <span class="badge badge-danger ml-1">{{ __('messages.urgent') }}</span>
                            @else
                                <span class="badge badge-info ml-1">{{ __('messages.normal') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('messages.location_information') }}</h5>
                                <dl>
                                    <dt>{{ __('messages.location') }}</dt>
                                    <dd>{{ $maintenanceRequest->location }}</dd>
                                    
                                    @if($maintenanceRequest->floor)
                                    <dt>{{ __('messages.floor') }}</dt>
                                    <dd>{{ $maintenanceRequest->floor }}</dd>
                                    @endif
                                </dl>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>{{ __('messages.request_information') }}</h5>
                                <dl>
                                    <dt>{{ __('messages.requester') }}</dt>
                                    <dd>{{ $maintenanceRequest->requester->name }}</dd>
                                    
                                    <dt>{{ __('messages.created_at') }}</dt>
                                    <dd>{{ $maintenanceRequest->created_at->format('Y-m-d H:i') }}</dd>
                                    
                                    <dt>{{ __('messages.id') }}</dt>
                                    <dd>#{{ $maintenanceRequest->id }}</dd>
                                </dl>
                            </div>
                        </div>
                        
                        @if($maintenanceRequest->description)
                        <h5>{{ __('messages.description') }}</h5>
                        <div class="p-3 bg-light">
                            <p class="mb-0">{{ $maintenanceRequest->description }}</p>
                        </div>
                        @endif
                        
                        @if($maintenanceRequest->materialRequests->count() > 0)
                        <hr>
                        <h5>{{ __('messages.related_material_requests') }} ({{ $maintenanceRequest->materialRequests->count() }})</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.id') }}</th>
                                        <th>{{ __('messages.item_description') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenanceRequest->materialRequests as $materialRequest)
                                    <tr>
                                        <td>{{ $materialRequest->id }}</td>
                                        <td>{{ $materialRequest->item_description }}</td>
                                        <td>{{ $materialRequest->quantity }}</td>
                                        <td>
                                            @switch($materialRequest->status)
                                                @case('pending')
                                                    <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                                    @break
                                                @case('approved')
                                                    <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                                    @break
                                                @case('fulfilled')
                                                    <span class="badge badge-info">{{ __('messages.fulfilled') }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @can('view', $materialRequest)
                                            <a href="{{ route('admin.material-requests.show', $materialRequest) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('admin.maintenance-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_list') }}
                            </a>
                            
                            @can('update', $maintenanceRequest)
                            <a href="{{ route('admin.maintenance-requests.edit', $maintenanceRequest) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                            </a>
                            @endcan
                            
                            @can('delete', $maintenanceRequest)
                            <form action="{{ route('admin.maintenance-requests.destroy', $maintenanceRequest) }}" method="POST" 
                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.status_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <h5>{{ __('messages.current_status') }}</h5>
                        <p>
                            @switch($maintenanceRequest->status)
                                @case('new')
                                    <span class="badge badge-primary">{{ __('messages.new') }}</span>
                                    <p class="mt-2">{{ __('messages.new_request_description') }}</p>
                                    @break
                                @case('in_progress')
                                    <span class="badge badge-warning">{{ __('messages.in_progress') }}</span>
                                    <p class="mt-2">{{ __('messages.in_progress_description') }}</p>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success">{{ __('messages.completed') }}</span>
                                    <p class="mt-2">{{ __('messages.completed_description') }}</p>
                                    @break
                                @case('transferred')
                                    <span class="badge badge-secondary">{{ __('messages.transferred') }}</span>
                                    <p class="mt-2">{{ __('messages.transferred_description') }}</p>
                                    @break
                            @endswitch
                        </p>
                        
                        <h5>{{ __('messages.timestamps') }}</h5>
                        <ul class="list-unstyled">
                            <li><strong>{{ __('messages.created') }}:</strong> {{ $maintenanceRequest->created_at->format('Y-m-d H:i') }}</li>
                            <li><strong>{{ __('messages.updated') }}:</strong> {{ $maintenanceRequest->updated_at->format('Y-m-d H:i') }}</li>
                            <li><strong>{{ __('messages.time_since_update') }}:</strong> {{ $maintenanceRequest->updated_at->diffForHumans() }}</li>
                        </ul>
                        
                        <h5>{{ __('messages.priority') }}</h5>
                        <p>
                            @if($maintenanceRequest->priority == 'urgent')
                                <span class="badge badge-danger">{{ __('messages.urgent') }}</span>
                                <p class="mt-2">{{ __('messages.urgent_description') }}</p>
                            @else
                                <span class="badge badge-info">{{ __('messages.normal') }}</span>
                                <p class="mt-2">{{ __('messages.normal_description') }}</p>
                            @endif
                        </p>
                        
                        @if($maintenanceRequest->status == 'new' && !auth()->user()->isAdmin() && $maintenanceRequest->requester_id == auth()->id())
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-1"></i> {{ __('messages.new_status_editable') }}
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('messages.quick_actions') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @can('create', App\Models\MaterialRequest::class)
                                <a href="{{ route('admin.material-requests.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-plus mr-2"></i> {{ __('messages.create_material_request') }}
                                </a>
                            @endcan
                            
                            <a href="{{ route('admin.maintenance-requests.index') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-list mr-2"></i> {{ __('messages.all_maintenance_requests') }}
                            </a>
                            
                            @if($maintenanceRequest->materialRequests->count() > 0)
                                <a href="{{ route('admin.material-requests.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-boxes mr-2"></i> {{ __('messages.view_material_requests') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 