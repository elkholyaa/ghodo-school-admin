<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * UserController
 * 
 * This controller handles the administration of users in the system.
 * It provides CRUD operations and is only accessible to admin users
 * via the is_admin middleware and UserPolicy authorization.
 */
class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * 
     * This method shows all users in the system with pagination.
     * Only admin users can access this page.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     * 
     * This method displays the form to create a new user.
     * Only admin users can access this page.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        
        $roles = User::getAvailableRoles();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     * 
     * This method processes the form submission from the create page.
     * Only admin users can create users.
     * 
     * @param  \App\Http\Requests\Admin\StoreUserRequest  $request
     */
    public function store(StoreUserRequest $request)
    {
        // Authorization is already handled in the form request
        
        $validatedData = $request->validated();
        
        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Create the user
        User::create($validatedData);
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User created successfully!'));
    }

    /**
     * Display the specified user.
     * 
     * This method shows the details of a specific user.
     * Only admin users can view user details.
     * 
     * @param  \App\Models\User  $user
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     * 
     * This method displays the form to edit an existing user.
     * Only admin users can edit users.
     * 
     * @param  \App\Models\User  $user
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        $roles = User::getAvailableRoles();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     * 
     * This method processes the form submission from the edit page.
     * Only admin users can update users.
     * 
     * @param  \App\Http\Requests\Admin\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Authorization is already handled in the form request
        
        $validatedData = $request->validated();
        
        // Only update password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        
        // Update the user
        $user->update($validatedData);
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User updated successfully!'));
    }

    /**
     * Remove the specified user from storage.
     * 
     * This method deletes a specific user.
     * Only admin users can delete users, and they cannot delete themselves.
     * This restriction is enforced by the UserPolicy.
     * 
     * @param  \App\Models\User  $user
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully!'));
    }
}
