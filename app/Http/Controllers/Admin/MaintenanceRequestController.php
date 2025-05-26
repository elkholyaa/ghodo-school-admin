<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMaintenanceRequestRequest;
use App\Http\Requests\Admin\UpdateMaintenanceRequestRequest;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * MaintenanceRequestController handles maintenance request functionality
 * 
 * This controller manages the CRUD operations for maintenance requests:
 * - Lists requests with proper filtering based on user role
 * - Allows creation of new requests
 * - Handles updates with proper permission checks
 * - Manages request deletion (admin only)
 * 
 * Educational Note: This demonstrates role-based authorization with policies,
 * eager loading to prevent N+1 query issues, and conditional data access patterns.
 */
class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * This method implements eager loading of the 'requester' relationship
     * to prevent N+1 query problems when displaying who created each request.
     * 
     * For admin users: Shows all maintenance requests
     * For staff users: Shows only their own requests
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Authorize viewAny from MaintenanceRequestPolicy
        $this->authorize('viewAny', MaintenanceRequest::class);
        
        $user = auth()->user();
        
        // Fetch maintenance requests with eager loading for requester relationship
        // to prevent N+1 query problem when accessing $request->requester in the view
        if ($user->isAdmin()) {
            // Admin sees all requests
            $maintenanceRequests = MaintenanceRequest::with('requester')
                                    ->latest()
                                    ->paginate(10);
        } else {
            // Staff sees only their own requests
            $maintenanceRequests = MaintenanceRequest::with('requester')
                                    ->where('requester_id', $user->id)
                                    ->latest()
                                    ->paginate(10);
        }
        
        // Return view with data
        return view('admin.maintenance_requests.index', compact('maintenanceRequests'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Authorize creation permission
        $this->authorize('create', MaintenanceRequest::class);
        
        // Get priorities and statuses for dropdowns
        $priorities = ['normal' => __('messages.normal'), 'urgent' => __('messages.urgent')];
        $statuses = [
            'new' => __('messages.new'),
            'in_progress' => __('messages.in_progress'),
            'completed' => __('messages.completed'),
            'transferred' => __('messages.transferred')
        ];
        
        return view('admin.maintenance_requests.create', compact('priorities', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \App\Http\Requests\Admin\StoreMaintenanceRequestRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMaintenanceRequestRequest $request)
    {
        // Validation is handled by StoreMaintenanceRequestRequest
        $validatedData = $request->validated();
        
        // Set the requester_id to the current user
        $validatedData['requester_id'] = auth()->id();
        
        // Create the maintenance request
        $maintenanceRequest = MaintenanceRequest::create($validatedData);
        
        // Redirect with success message
        return redirect()->route('admin.maintenance-requests.index')
                         ->with('success', __('messages.maintenance_request_created'));
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\View\View
     */
    public function show(MaintenanceRequest $maintenanceRequest)
    {
        // Authorize viewing this specific request
        $this->authorize('view', $maintenanceRequest);
        
        // Eager load relationships to prevent N+1 problems
        $maintenanceRequest->load(['requester', 'materialRequests']);
        
        return view('admin.maintenance_requests.show', compact('maintenanceRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \App\Models\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\View\View
     */
    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        // Authorize editing this specific request
        $this->authorize('update', $maintenanceRequest);
        
        // Get priorities and statuses for dropdowns
        $priorities = ['normal' => __('messages.normal'), 'urgent' => __('messages.urgent')];
        $statuses = [
            'new' => __('messages.new'),
            'in_progress' => __('messages.in_progress'),
            'completed' => __('messages.completed'),
            'transferred' => __('messages.transferred')
        ];
        
        return view('admin.maintenance_requests.edit', compact('maintenanceRequest', 'priorities', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \App\Http\Requests\Admin\UpdateMaintenanceRequestRequest  $request
     * @param  \App\Models\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMaintenanceRequestRequest $request, MaintenanceRequest $maintenanceRequest)
    {
        // Validation and authorization are handled by UpdateMaintenanceRequestRequest
        $validatedData = $request->validated();
        
        // Update the maintenance request
        $maintenanceRequest->update($validatedData);
        
        // Redirect with success message
        return redirect()->route('admin.maintenance-requests.index')
                         ->with('success', __('messages.maintenance_request_updated'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \App\Models\MaintenanceRequest  $maintenanceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        // Authorize deletion permission
        $this->authorize('delete', $maintenanceRequest);
        
        // Delete the maintenance request
        $maintenanceRequest->delete();
        
        // Redirect with success message
        return redirect()->route('admin.maintenance-requests.index')
                         ->with('success', __('messages.maintenance_request_deleted'));
    }
}
