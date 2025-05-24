<?php

namespace App\Policies;

use App\Models\MaterialRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * MaterialRequestPolicy - Authorization Policy for Material Requests
 * 
 * This policy controls access to material request operations based on user roles:
 * - Admin users: Full access to all material requests
 * - Staff users: Can view/create requests, edit only their own 'pending' requests
 * 
 * Educational Note: Laravel Policies centralize authorization logic and work
 * seamlessly with controller authorization and Blade @can directives.
 * This demonstrates conditional authorization based on both role and model state.
 */
class MaterialRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     * Both admin and staff users can access the material requests list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view all requests, staff can only view their own requests.
     */
    public function view(User $user, MaterialRequest $materialRequest): bool
    {
        return $user->isAdmin() || 
               ($user->role === 'staff' && $user->id === $materialRequest->requester_id);
    }

    /**
     * Determine whether the user can create models.
     * Both admin and staff users can create material requests.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any request, staff can only update their own 'pending' requests.
     * 
     * Note: Staff users lose edit access once their request moves beyond 'pending' status.
     */
    public function update(User $user, MaterialRequest $materialRequest): bool
    {
        return $user->isAdmin() || 
               ($user->role === 'staff' && 
                $user->id === $materialRequest->requester_id && 
                $materialRequest->status === 'pending');
    }

    /**
     * Determine whether the user can delete the model.
     * Only admin users can delete material requests. Staff cannot delete.
     */
    public function delete(User $user, MaterialRequest $materialRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaterialRequest $materialRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaterialRequest $materialRequest): bool
    {
        return $user->isAdmin();
    }
}
