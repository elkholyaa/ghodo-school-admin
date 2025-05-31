<?php
/**
 * Purpose: This file displays the list of maintenance requests in the admin panel.
 *
 * Role and Relation: This Blade template extends the main admin layout ('layouts.admin')
 * and is responsible for rendering the main content area for the maintenance requests
 * index page. It receives data from the MaintenanceRequestController's index method.
 */
?>
@extends('layouts.admin')

@section('content')
<!-- Simple clean layout with proper RTL support -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <!-- Title - right aligned for RTL -->
            <div class="col-sm-6 text-right">
                <h1 class="m-0">{{ __('messages.maintenance_requests') }}</h1>
            </div>
            <!-- Breadcrumbs - right aligned for RTL -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.maintenance_requests') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Action button - right aligned for RTL -->
                <div class="text-right mb-3">
                    @can('create', App\Models\MaintenanceRequest::class)
                        <a href="{{ route('admin.maintenance-requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus ml-2"></i> {{ __('messages.add_new') }}
                        </a>
                    @endcan
                </div>
                
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('messages.title') }}</th>
                                    <th class="d-none d-md-table-cell">{{ __('messages.location') }}</th>
                                    <th>{{ __('messages.priority') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th class="d-none d-md-table-cell">{{ __('messages.requester') }}</th>
                                    <th class="d-none d-md-table-cell">{{ __('messages.created_at') }}</th>
                                    <th width="150">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($maintenanceRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ Str::limit($request->title, 30) }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($request->floor)
                                            {{ $request->floor }} - 
                                        @endif
                                        {{ $request->location }}
                                    </td>
                                    <td>
                                        @if($request->priority == 'urgent')
                                            <span class="badge badge-danger">{{ __('messages.urgent') }}</span>
                                        @else
                                            <span class="badge badge-info">{{ __('messages.normal') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($request->status)
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
                                            @default
                                                <span class="badge badge-light">{{ $request->status }}</span>
                                        @endswitch
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $request->requester->name }}
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $request->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('view', $request)
                                            <a href="{{ route('admin.maintenance-requests.show', $request) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('update', $request)
                                            <a href="{{ route('admin.maintenance-requests.edit', $request) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete', $request)
                                            <form action="{{ route('admin.maintenance-requests.destroy', $request) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('messages.no_maintenance_requests') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $maintenanceRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 