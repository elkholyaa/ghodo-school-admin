<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\MaterialRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * DashboardTest - Feature Testing for Dashboard Functionality
 * 
 * This test class verifies the dashboard functionality from an end-user perspective:
 * - Tests role-based dashboard content (admin vs staff)
 * - Verifies route redirects work correctly
 * - Ensures proper data is displayed for different user roles
 * - Tests authorization and access control
 * 
 * Educational Note: Feature tests simulate actual user interactions and
 * test the complete flow from HTTP request to response, including
 * middleware, controllers, and views.
 */
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $staffUser;

    /**
     * Set up test data before each test
     * 
     * Creates admin and staff users for testing different role scenarios
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@test.com'
        ]);
        
        // Create a staff user
        $this->staffUser = User::factory()->create([
            'role' => 'staff',
            'name' => 'Staff User',
            'email' => 'staff@test.com'
        ]);
    }

    /**
     * Test that root URL redirects unauthenticated users to login
     */
    public function test_root_redirects_unauthenticated_to_login(): void
    {
        $response = $this->get('/');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test that root URL redirects authenticated users to admin dashboard
     */
    public function test_root_redirects_authenticated_to_admin_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/');
        
        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test that admin dashboard is accessible to authenticated users
     */
    public function test_admin_dashboard_accessible_to_authenticated_users(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /**
     * Test that admin dashboard requires authentication
     */
    public function test_admin_dashboard_requires_authentication(): void
    {
        $response = $this->get('/admin/dashboard');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test that admin users see admin-specific dashboard content
     */
    public function test_admin_sees_admin_dashboard_content(): void
    {
        // Create some test data
        User::factory()->count(5)->create(); // Additional users
        
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('إجمالي المستخدمين'); // Total users in Arabic
        $response->assertSee('طلبات الصيانة المعلقة'); // Pending maintenance requests
        $response->assertSee('طلبات المواد المعلقة'); // Pending material requests
        $response->assertSee('نظرة عامة على النظام'); // System overview
        
        // Should see user count (5 factory users + 2 test users = 7)
        $response->assertSee('7'); // Total user count
    }

    /**
     * Test that staff users see staff-specific dashboard content
     */
    public function test_staff_sees_staff_dashboard_content(): void
    {
        $response = $this->actingAs($this->staffUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('طلبات الصيانة المعلقة لي'); // My pending maintenance requests
        $response->assertSee('طلبات المواد المعلقة لي'); // My pending material requests
        $response->assertSee('معلومات الموظف'); // Staff info
        $response->assertSee('مرحبًا بك', false); // Welcome message (without escaping HTML)
        $response->assertSee('Staff User'); // Username
        
        // Should NOT see admin-specific content
        $response->assertDontSee('إجمالي المستخدمين'); // Total users
        $response->assertDontSee('نظرة عامة على النظام'); // System overview
    }

    /**
     * Test admin dashboard data accuracy with maintenance requests
     */
    public function test_admin_dashboard_shows_correct_maintenance_request_counts(): void
    {
        // Create test maintenance requests with different statuses
        MaintenanceRequest::factory()->create(['status' => 'new', 'requester_id' => $this->staffUser->id]);
        MaintenanceRequest::factory()->create(['status' => 'in_progress', 'requester_id' => $this->staffUser->id]);
        MaintenanceRequest::factory()->create(['status' => 'completed', 'requester_id' => $this->staffUser->id]);
        MaintenanceRequest::factory()->create(['status' => 'new', 'requester_id' => $this->adminUser->id]);

        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        
        // Should show 3 pending requests (new + in_progress = 2 + 1 = 3)
        $response->assertViewHas('pendingMaintenanceCount', 3);
    }

    /**
     * Test admin dashboard data accuracy with material requests
     */
    public function test_admin_dashboard_shows_correct_material_request_counts(): void
    {
        // Create test material requests with different statuses
        MaterialRequest::factory()->create(['status' => 'pending', 'requester_id' => $this->staffUser->id]);
        MaterialRequest::factory()->create(['status' => 'pending', 'requester_id' => $this->adminUser->id]);
        MaterialRequest::factory()->create(['status' => 'approved', 'requester_id' => $this->staffUser->id]);
        MaterialRequest::factory()->create(['status' => 'rejected', 'requester_id' => $this->staffUser->id]);

        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        
        // Should show 2 pending material requests
        $response->assertViewHas('pendingMaterialCount', 2);
    }

    /**
     * Test staff dashboard shows only their own maintenance requests
     */
    public function test_staff_dashboard_shows_only_own_maintenance_requests(): void
    {
        // Create maintenance requests for different users
        MaintenanceRequest::factory()->create(['status' => 'new', 'requester_id' => $this->staffUser->id]);
        MaintenanceRequest::factory()->create(['status' => 'in_progress', 'requester_id' => $this->staffUser->id]);
        MaintenanceRequest::factory()->create(['status' => 'new', 'requester_id' => $this->adminUser->id]); // Different user
        MaintenanceRequest::factory()->create(['status' => 'completed', 'requester_id' => $this->staffUser->id]); // Completed

        $response = $this->actingAs($this->staffUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        
        // Should show 2 pending requests for this staff user only
        $response->assertViewHas('userPendingMaintenanceCount', 2);
    }

    /**
     * Test staff dashboard shows only their own material requests
     */
    public function test_staff_dashboard_shows_only_own_material_requests(): void
    {
        // Create material requests for different users
        MaterialRequest::factory()->create(['status' => 'pending', 'requester_id' => $this->staffUser->id]);
        MaterialRequest::factory()->create(['status' => 'pending', 'requester_id' => $this->adminUser->id]); // Different user
        MaterialRequest::factory()->create(['status' => 'approved', 'requester_id' => $this->staffUser->id]); // Not pending

        $response = $this->actingAs($this->staffUser)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        
        // Should show 1 pending request for this staff user only
        $response->assertViewHas('userPendingMaterialCount', 1);
    }

    /**
     * Test that dashboard view receives correct user role
     */
    public function test_dashboard_passes_correct_user_role(): void
    {
        // Test admin role
        $adminResponse = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        $adminResponse->assertViewHas('userRole', 'admin');
        
        // Test staff role
        $staffResponse = $this->actingAs($this->staffUser)->get('/admin/dashboard');
        $staffResponse->assertViewHas('userRole', 'staff');
    }

    /**
     * Test that old /dashboard route no longer exists
     */
    public function test_old_dashboard_route_does_not_exist(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');
        
        // Should return 404 since we removed this route
        $response->assertStatus(404);
    }

    /**
     * Test dashboard with no maintenance or material requests (edge case)
     */
    public function test_dashboard_with_no_requests(): void
    {
        $adminResponse = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        $adminResponse->assertViewHas('pendingMaintenanceCount', 0);
        $adminResponse->assertViewHas('pendingMaterialCount', 0);

        $staffResponse = $this->actingAs($this->staffUser)->get('/admin/dashboard');
        $staffResponse->assertViewHas('userPendingMaintenanceCount', 0);
        $staffResponse->assertViewHas('userPendingMaterialCount', 0);
    }
}
