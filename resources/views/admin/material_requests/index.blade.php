{{--
    Material Requests Index View
    
    This view displays a paginated list of material requests with role-based filtering:
    - Admin users see all material requests
    - Staff users see only their own requests
    
    Educational Note: This demonstrates AdminLTE table styling, Blade @can directives
    for authorization, and proper relationship data display with eager loading.
--}}

@extends('layouts.admin')

@section('title', __('messages.Material Requests'))

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.Material Requests') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Material Requests') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('messages.Material Requests List') }}</h3>
                
                @can('create', App\Models\MaterialRequest::class)
                    <div class="card-tools">
                        <a href="{{ route('admin.material-requests.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('messages.Add New Request') }}
                        </a>
                    </div>
                @endcan
            </div>
            
            <div class="card-body table-responsive p-0">
                @if($materialRequests->count() > 0)
                    <table class="table table-hover text-nowrap material-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.ID') }}</th>
                                <th>{{ __('messages.Item Description') }}</th>
                                <th>{{ __('messages.Quantity') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('messages.Cost') }}</th>
                                <th>{{ __('messages.Status') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('messages.Requester') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('messages.Maintenance Request') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('messages.Created At') }}</th>
                                <th>{{ __('messages.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materialRequests as $materialRequest)
                                <tr>
                                    <td>{{ $materialRequest->id }}</td>
                                    <td>{{ Str::limit($materialRequest->item_description, 30) }}</td>
                                    <td>{{ $materialRequest->quantity }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($materialRequest->cost)
                                            ${{ number_format($materialRequest->cost, 2) }}
                                        @else
                                            <span class="text-muted">{{ __('messages.Not specified') }}</span>
                                        @endif
                                    </td>
                                    <td>
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
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($materialRequest->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $materialRequest->requester->name }}</td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($materialRequest->maintenanceRequest)
                                            <a href="{{ route('admin.maintenance-requests.show', $materialRequest->maintenanceRequest) }}" 
                                               class="text-primary">
                                                #{{ $materialRequest->maintenanceRequest->id }} - {{ Str::limit($materialRequest->maintenanceRequest->title, 20) }}
                                            </a>
                                        @else
                                            <span class="text-muted">{{ __('messages.Standalone Request') }}</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $materialRequest->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view', $materialRequest)
                                                <a href="{{ route('admin.material-requests.show', $materialRequest) }}" 
                                                   class="btn btn-info btn-sm" title="{{ __('messages.View') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('update', $materialRequest)
                                                <a href="{{ route('admin.material-requests.edit', $materialRequest) }}" 
                                                   class="btn btn-warning btn-sm" title="{{ __('messages.Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('delete', $materialRequest)
                                                <form action="{{ route('admin.material-requests.destroy', $materialRequest) }}" 
                                                      method="POST" style="display: inline;"
                                                      onsubmit="return confirm('{{ __('messages.Are you sure you want to delete this material request?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            title="{{ __('messages.Delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">{{ __('messages.No material requests found.') }}</p>
                        @can('create', App\Models\MaterialRequest::class)
                            <a href="{{ route('admin.material-requests.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('messages.Create First Request') }}
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
            
            @if($materialRequests->hasPages())
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $materialRequests->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            {{ __('messages.Showing') }} {{ $materialRequests->firstItem() }} {{ __('messages.to') }} 
                            {{ $materialRequests->lastItem() }} {{ __('messages.of') }} {{ $materialRequests->total() }} 
                            {{ __('messages.results') }}
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection 