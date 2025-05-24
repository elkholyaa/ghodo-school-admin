<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMaterialRequestRequest;
use App\Http\Requests\Admin\UpdateMaterialRequestRequest;
use App\Models\MaterialRequest;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

/**
 * MaterialRequestController - Handles CRUD operations for Material Requests
 * 
 * This controller manages material requests with role-based authorization:
 * - Admin users: Full access to all material requests
 * - Staff users: Can view/create requests, edit only their own 'pending' requests
 * 
 * Educational Note: This demonstrates resourceful controllers with authorization,
 * eager loading relationships, and form request validation in Laravel.
 */
class MaterialRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * Shows paginated material requests with requester and maintenance request info.
     * Admin sees all requests, staff sees only their own requests.
     */
    public function index()
    {
        $this->authorize('viewAny', MaterialRequest::class);
        
        $query = MaterialRequest::with(['requester', 'maintenanceRequest']);
        
        // Staff users can only see their own requests
        if (!auth()->user()->isAdmin()) {
            $query->where('requester_id', auth()->id());
        }
        
        $materialRequests = $query->latest()->paginate(15);
        
        return view('admin.material_requests.index', compact('materialRequests'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * Displays the creation form with open maintenance requests for linking.
     */
    public function create()
    {
        $this->authorize('create', MaterialRequest::class);
        
        // Fetch open maintenance requests for the dropdown
        $openMaintenanceRequests = MaintenanceRequest::whereIn('status', ['new', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $fundingSources = [
            'school_budget' => 'School Budget',
            'maintenance' => 'Maintenance',
            'other' => 'Other'
        ];
        
        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'fulfilled' => 'Fulfilled'
        ];
        
        return view('admin.material_requests.create', compact('openMaintenanceRequests', 'fundingSources', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Creates a new material request with the authenticated user as requester.
     */
    public function store(StoreMaterialRequestRequest $request)
    {
        $validatedData = $request->validated();
        
        // Set the requester to the authenticated user
        $validatedData['requester_id'] = auth()->id();
        
        MaterialRequest::create($validatedData);
        
        return redirect()->route('admin.material-requests.index')
            ->with('success', 'Material request created successfully!');
    }

    /**
     * Display the specified resource.
     * 
     * Shows detailed view of a single material request.
     */
    public function show(MaterialRequest $materialRequest)
    {
        $this->authorize('view', $materialRequest);
        
        // Eager load relationships
        $materialRequest->load(['requester', 'maintenanceRequest']);
        
        return view('admin.material_requests.show', compact('materialRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Displays the edit form with current data and open maintenance requests.
     */
    public function edit(MaterialRequest $materialRequest)
    {
        $this->authorize('update', $materialRequest);
        
        // Fetch open maintenance requests for the dropdown
        $openMaintenanceRequests = MaintenanceRequest::whereIn('status', ['new', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $fundingSources = [
            'school_budget' => 'School Budget',
            'maintenance' => 'Maintenance',
            'other' => 'Other'
        ];
        
        $statuses = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'fulfilled' => 'Fulfilled'
        ];
        
        return view('admin.material_requests.edit', compact('materialRequest', 'openMaintenanceRequests', 'fundingSources', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * Updates the material request with validated data.
     * Authorization is handled by the UpdateMaterialRequestRequest.
     */
    public function update(UpdateMaterialRequestRequest $request, MaterialRequest $materialRequest)
    {
        $validatedData = $request->validated();
        
        $materialRequest->update($validatedData);
        
        return redirect()->route('admin.material-requests.index')
            ->with('success', 'Material request updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Deletes the material request (admin only).
     */
    public function destroy(MaterialRequest $materialRequest)
    {
        $this->authorize('delete', $materialRequest);
        
        $materialRequest->delete();
        
        return redirect()->route('admin.material-requests.index')
            ->with('success', 'Material request deleted successfully!');
    }
}
