<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * MaintenanceRequestPolicy - Authorization Policy for Maintenance Requests
 * 
 * This policy controls access to maintenance request operations based on user roles:
 * - Admin users: Full access to all maintenance requests
 * - Staff users: Can view/create requests, edit only their own 'new' requests
 * 
 * Educational Note: Laravel Policies centralize authorization logic and work
 * seamlessly with controller authorization and Blade @can directives.
 */
class MaintenanceRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     * Both admin and staff users can access the maintenance requests list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view all requests, staff can only view their own requests.
     */
    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() || 
               ($user->role === 'staff' && $user->id === $maintenanceRequest->requester_id);
    }

    /**
     * Determine whether the user can create models.
     * Both admin and staff users can create maintenance requests.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any request, staff can only update their own 'new' requests.
     */
    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() || 
               ($user->role === 'staff' && 
                $user->id === $maintenanceRequest->requester_id && 
                $maintenanceRequest->status === 'new');
    }

    /**
     * Determine whether the user can delete the model.
     * Only admin users can delete maintenance requests. Staff cannot delete.
     */
    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }
}
