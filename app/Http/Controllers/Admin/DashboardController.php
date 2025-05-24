<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;

/**
 * DashboardController handles the admin dashboard functionality
 * 
 * This controller manages the main admin dashboard that displays:
 * - Role-specific summary widgets and statistics
 * - Different data for admin vs staff users
 * - Counts of various entities like users, maintenance requests, material requests
 * 
 * Educational Note: This demonstrates conditional logic based on user roles,
 * basic Eloquent queries for data aggregation, and passing data to views.
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with role-specific data
     * 
     * This method implements the logic from Phase 3, Task 3.5.1 of the SRS:
     * - Checks user role using isAdmin() helper
     * - Fetches different counts based on role (admin sees all, staff sees own)
     * - Passes data to the dashboard view
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        
        // Initialize variables for dashboard data
        $data = [];
        
        if ($user->isAdmin()) {
            // Admin sees all system data
            $data = [
                'usersCount' => User::count(),
                'pendingMaintenanceCount' => MaintenanceRequest::whereIn('status', ['new', 'in_progress'])->count(),
                'pendingMaterialCount' => MaterialRequest::where('status', 'pending')->count(),
                'userRole' => 'admin'
            ];
        } else {
            // Staff sees only their own data
            $data = [
                'userPendingMaintenanceCount' => MaintenanceRequest::where('requester_id', $user->id)
                    ->whereIn('status', ['new', 'in_progress'])
                    ->count(),
                'userPendingMaterialCount' => MaterialRequest::where('requester_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),
                'userRole' => 'staff'
            ];
        }
        
        return view('admin.dashboard', $data);
    }
} 