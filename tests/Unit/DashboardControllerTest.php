<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\MaterialRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * DashboardControllerTest - Unit Testing for DashboardController
 * 
 * This test class verifies the DashboardController logic in isolation:
 * - Tests controller methods independently of HTTP layer
 * - Verifies data processing and business logic
 * - Tests role-based data fetching logic
 * 
 * Educational Note: Unit tests for controllers focus on testing the controller
 * logic separate from routing, middleware, and full HTTP request/response cycle.
 */
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    /**
     * Set up the test environment
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new DashboardController();
    }

    /**
     * Test that dashboard controller can be instantiated
     */
    public function test_dashboard_controller_can_be_instantiated(): void
    {
        $this->assertInstanceOf(DashboardController::class, $this->controller);
    }

    /**
     * Test that admin gets all system data.
     */
    public function test_admin_gets_all_system_data(): void
    {
        // Create admin user
        $adminUser = User::factory()->create(['role' => 'admin']);
        
        // Clear existing test data for isolation
        MaintenanceRequest::query()->delete();
        MaterialRequest::query()->delete();
        
        // Create specific test data
        $users = User::factory()->count(3)->create();
        MaintenanceRequest::factory()->count(2)->create(['status' => 'new']);
        MaintenanceRequest::factory()->count(1)->create(['status' => 'in_progress']);
        MaintenanceRequest::factory()->count(1)->create(['status' => 'completed']); // Should not be counted
        
        MaterialRequest::factory()->count(3)->create(['status' => 'pending']);
        MaterialRequest::factory()->count(1)->create(['status' => 'approved']); // Should not be counted

        // Act as admin
        $this->actingAs($adminUser);
        $response = $this->controller->index();
        $data = $response->getData();

        // Assert admin-specific data
        $this->assertEquals('admin', $data['userRole']);
        $this->assertGreaterThanOrEqual(4, $data['usersCount']); // At least 3 factory + 1 admin
        $this->assertEquals(3, $data['pendingMaintenanceCount']); // new + in_progress
        $this->assertEquals(3, $data['pendingMaterialCount']); // pending only
    }

    /**
     * Test staff data fetching logic
     */
    public function test_staff_gets_only_own_data(): void
    {
        // Create users
        $staffUser = User::factory()->create(['role' => 'staff']);
        $otherUser = User::factory()->create(['role' => 'staff']);
        
        // Create maintenance requests for different users
        MaintenanceRequest::factory()->count(2)->create([
            'requester_id' => $staffUser->id,
            'status' => 'new'
        ]);
        MaintenanceRequest::factory()->count(1)->create([
            'requester_id' => $staffUser->id,
            'status' => 'in_progress'
        ]);
        MaintenanceRequest::factory()->count(1)->create([
            'requester_id' => $staffUser->id,
            'status' => 'completed' // Should not count
        ]);
        MaintenanceRequest::factory()->count(2)->create([
            'requester_id' => $otherUser->id,
            'status' => 'new' // Should not count (different user)
        ]);

        // Create material requests for different users
        MaterialRequest::factory()->count(2)->create([
            'requester_id' => $staffUser->id,
            'status' => 'pending'
        ]);
        MaterialRequest::factory()->count(1)->create([
            'requester_id' => $staffUser->id,
            'status' => 'approved' // Should not count
        ]);
        MaterialRequest::factory()->count(1)->create([
            'requester_id' => $otherUser->id,
            'status' => 'pending' // Should not count (different user)
        ]);

        // Authenticate the staff user
        $this->actingAs($staffUser);

        // Call the controller method
        $response = $this->controller->index();

        // Get the view data
        $data = $response->getData();

        // Assert staff-specific data
        $this->assertEquals('staff', $data['userRole']);
        $this->assertEquals(3, $data['userPendingMaintenanceCount']); // 2 new + 1 in_progress for this user
        $this->assertEquals(2, $data['userPendingMaterialCount']); // 2 pending for this user

        // Assert admin-specific data is not present
        $this->assertArrayNotHasKey('usersCount', $data);
        $this->assertArrayNotHasKey('pendingMaintenanceCount', $data);
        $this->assertArrayNotHasKey('pendingMaterialCount', $data);
    }

    /**
     * Test that admin data includes system-wide counts regardless of requester
     */
    public function test_admin_sees_all_requests_regardless_of_requester(): void
    {
        // Create users
        $adminUser = User::factory()->create(['role' => 'admin']);
        $staffUser1 = User::factory()->create(['role' => 'staff']);
        $staffUser2 = User::factory()->create(['role' => 'staff']);

        // Create requests from different users
        MaintenanceRequest::factory()->create([
            'requester_id' => $adminUser->id,
            'status' => 'new'
        ]);
        MaintenanceRequest::factory()->create([
            'requester_id' => $staffUser1->id,
            'status' => 'in_progress'
        ]);
        MaintenanceRequest::factory()->create([
            'requester_id' => $staffUser2->id,
            'status' => 'new'
        ]);

        MaterialRequest::factory()->create([
            'requester_id' => $adminUser->id,
            'status' => 'pending'
        ]);
        MaterialRequest::factory()->create([
            'requester_id' => $staffUser1->id,
            'status' => 'pending'
        ]);

        // Authenticate as admin
        $this->actingAs($adminUser);

        // Call the controller method
        $response = $this->controller->index();
        $data = $response->getData();

        // Admin should see ALL requests regardless of who submitted them
        $this->assertEquals(3, $data['pendingMaintenanceCount']); // All 3 pending requests
        $this->assertEquals(2, $data['pendingMaterialCount']); // All 2 pending material requests
    }

    /**
     * Test controller returns correct view
     */
    public function test_controller_returns_admin_dashboard_view(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $response = $this->controller->index();

        $this->assertEquals('admin.dashboard', $response->getName());
    }

    /**
     * Test with no requests (edge case)
     */
    public function test_dashboard_handles_no_requests_gracefully(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $response = $this->controller->index();
        $data = $response->getData();

        $this->assertEquals(0, $data['pendingMaintenanceCount']);
        $this->assertEquals(0, $data['pendingMaterialCount']);
    }

    /**
     * Test staff with no personal requests
     */
    public function test_staff_with_no_personal_requests(): void
    {
        $staffUser = User::factory()->create(['role' => 'staff']);
        
        // Create requests for other users but not for this staff user
        $otherUser = User::factory()->create(['role' => 'staff']);
        MaintenanceRequest::factory()->create([
            'requester_id' => $otherUser->id,
            'status' => 'new'
        ]);
        MaterialRequest::factory()->create([
            'requester_id' => $otherUser->id,
            'status' => 'pending'
        ]);

        $this->actingAs($staffUser);

        $response = $this->controller->index();
        $data = $response->getData();

        // This staff user should see 0 for their personal counts
        $this->assertEquals(0, $data['userPendingMaintenanceCount']);
        $this->assertEquals(0, $data['userPendingMaterialCount']);
    }

    /**
     * Test that status filtering works correctly.
     */
    public function test_status_filtering_works_correctly(): void
    {
        // Create admin user
        $adminUser = User::factory()->create(['role' => 'admin']);
        
        // Clear existing data for this test
        MaintenanceRequest::query()->delete();
        MaterialRequest::query()->delete();
        
        // Create specific test data
        MaintenanceRequest::factory()->count(2)->create(['status' => 'new']);
        MaintenanceRequest::factory()->count(1)->create(['status' => 'completed']); // Should not be counted
        
        MaterialRequest::factory()->count(1)->create(['status' => 'pending']);
        MaterialRequest::factory()->count(1)->create(['status' => 'approved']); // Should not be counted

        $this->actingAs($adminUser);

        $response = $this->controller->index();
        $data = $response->getData();

        $this->assertEquals(2, $data['pendingMaintenanceCount']); // Only new + in_progress
        $this->assertEquals(1, $data['pendingMaterialCount']); // Only pending
    }
}
