<?php

/**
 * MaterialRequestTest - Feature Tests for Material Request Management
 * 
 * This test file covers complete CRUD operations and authorization rules:
 * - Testing that both admin and staff can create/view requests appropriately
 * - Testing permission boundaries (staff can only edit their own pending requests)
 * - Testing request-maintenance request relationships
 * - Testing that requester_id is automatically set during creation
 * 
 * Educational Note: Feature tests simulate HTTP requests to test the complete
 * application flow including routes, controllers, policies, and database interactions.
 * Using RefreshDatabase ensures clean test isolation.
 */

namespace Tests\Feature;

use App\Models\User;
use App\Models\MaterialRequest;
use App\Models\MaintenanceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->otherStaff = User::factory()->create(['role' => 'staff']);
    }

    /** @test */
    public function admin_can_view_material_requests_index()
    {
        // Create some material requests
        MaterialRequest::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.material-requests.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.index');
    }

    /** @test */
    public function staff_can_view_material_requests_index()
    {
        // Create some material requests
        MaterialRequest::factory()->count(3)->create();

        $response = $this->actingAs($this->staff)
            ->get(route('admin.material-requests.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.index');
    }

    /** @test */
    public function unauthenticated_user_cannot_access_material_requests()
    {
        $response = $this->get(route('admin.material-requests.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_create_material_request()
    {
        $materialRequestData = [
            'item_description' => 'Test Material Item',
            'quantity' => 5,
            'cost' => 150.50,
            'funding_source' => 'school_budget',
            'status' => 'pending',
            'maintenance_request_id' => null,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.material-requests.store'), $materialRequestData);

        $response->assertRedirect(route('admin.material-requests.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('material_requests', [
            'item_description' => 'Test Material Item',
            'quantity' => 5,
            'cost' => 150.50,
            'requester_id' => $this->admin->id, // Should be set automatically
        ]);
    }

    /** @test */
    public function staff_can_create_material_request()
    {
        $materialRequestData = [
            'item_description' => 'Staff Material Request',
            'quantity' => 2,
            'status' => 'pending',
        ];

        $response = $this->actingAs($this->staff)
            ->post(route('admin.material-requests.store'), $materialRequestData);

        $response->assertRedirect(route('admin.material-requests.index'));
        
        $this->assertDatabaseHas('material_requests', [
            'item_description' => 'Staff Material Request',
            'requester_id' => $this->staff->id, // Automatically set to authenticated user
        ]);
    }

    /** @test */
    public function material_request_can_be_linked_to_maintenance_request()
    {
        $maintenanceRequest = MaintenanceRequest::factory()->create([
            'status' => 'new',
            'requester_id' => $this->admin->id,
        ]);

        $materialRequestData = [
            'item_description' => 'Materials for maintenance',
            'quantity' => 1,
            'status' => 'pending',
            'maintenance_request_id' => $maintenanceRequest->id,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.material-requests.store'), $materialRequestData);

        $response->assertRedirect(route('admin.material-requests.index'));
        
        $this->assertDatabaseHas('material_requests', [
            'item_description' => 'Materials for maintenance',
            'maintenance_request_id' => $maintenanceRequest->id,
        ]);
    }

    /** @test */
    public function admin_can_update_any_material_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'pending',
        ]);

        $updateData = [
            'item_description' => 'Updated by Admin',
            'quantity' => 10,
            'status' => 'approved',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.material-requests.update', $materialRequest), $updateData);

        $response->assertRedirect(route('admin.material-requests.index'));
        
        $this->assertDatabaseHas('material_requests', [
            'id' => $materialRequest->id,
            'item_description' => 'Updated by Admin',
            'quantity' => 10,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function staff_can_update_their_own_pending_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'pending',
        ]);

        $updateData = [
            'item_description' => 'Updated by Staff',
            'quantity' => 3,
            'status' => 'pending', // Staff can only keep it pending
        ];

        $response = $this->actingAs($this->staff)
            ->put(route('admin.material-requests.update', $materialRequest), $updateData);

        $response->assertRedirect(route('admin.material-requests.index'));
        
        $this->assertDatabaseHas('material_requests', [
            'id' => $materialRequest->id,
            'item_description' => 'Updated by Staff',
            'quantity' => 3,
        ]);
    }

    /** @test */
    public function staff_cannot_update_approved_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'approved',
        ]);

        $updateData = [
            'item_description' => 'Trying to update approved request',
            'quantity' => 99,
        ];

        $response = $this->actingAs($this->staff)
            ->put(route('admin.material-requests.update', $materialRequest), $updateData);

        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function staff_cannot_update_other_staff_requests()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->otherStaff->id,
            'status' => 'pending',
        ]);

        $updateData = [
            'item_description' => 'Trying to update other staff request',
            'quantity' => 99,
        ];

        $response = $this->actingAs($this->staff)
            ->put(route('admin.material-requests.update', $materialRequest), $updateData);

        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function admin_can_delete_any_material_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.material-requests.destroy', $materialRequest));

        $response->assertRedirect(route('admin.material-requests.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('material_requests', [
            'id' => $materialRequest->id,
        ]);
    }

    /** @test */
    public function staff_cannot_delete_any_material_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->staff)
            ->delete(route('admin.material-requests.destroy', $materialRequest));

        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseHas('material_requests', [
            'id' => $materialRequest->id,
        ]);
    }

    /** @test */
    public function admin_can_view_material_request_details()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.material-requests.show', $materialRequest));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.show');
        $response->assertViewHas('materialRequest', $materialRequest);
    }

    /** @test */
    public function staff_can_view_their_own_material_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
        ]);

        $response = $this->actingAs($this->staff)
            ->get(route('admin.material-requests.show', $materialRequest));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.show');
    }

    /** @test */
    public function staff_cannot_view_other_staff_material_request()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->otherStaff->id,
        ]);

        $response = $this->actingAs($this->staff)
            ->get(route('admin.material-requests.show', $materialRequest));

        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function validation_prevents_invalid_material_request_creation()
    {
        $invalidData = [
            'item_description' => '', // Required field missing
            'quantity' => 0, // Must be at least 1
            'cost' => -10, // Cannot be negative
            'funding_source' => 'invalid_source', // Not in allowed enum values
            'status' => 'invalid_status', // Not in allowed enum values
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.material-requests.store'), $invalidData);

        $response->assertSessionHasErrors([
            'item_description',
            'quantity',
            'cost',
            'funding_source',
            'status',
        ]);
    }

    /** @test */
    public function create_view_displays_open_maintenance_requests()
    {
        $openRequest = MaintenanceRequest::factory()->create(['status' => 'new']);
        $closedRequest = MaintenanceRequest::factory()->create(['status' => 'completed']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.material-requests.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.create');
        
        // Should include open maintenance request in dropdown data
        $viewData = $response->viewData('openMaintenanceRequests');
        $this->assertTrue($viewData->contains($openRequest));
        $this->assertFalse($viewData->contains($closedRequest));
    }

    /** @test */
    public function edit_view_displays_request_data_correctly()
    {
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->admin->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.material-requests.edit', $materialRequest));

        $response->assertStatus(200);
        $response->assertViewIs('admin.material_requests.edit');
        $response->assertViewHas('materialRequest', $materialRequest);
    }
} 