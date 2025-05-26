<?php

namespace Tests\Feature;

use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $staffUser;
    protected $anotherStaffUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users with different roles
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->staffUser = User::factory()->create(['role' => 'staff']);
        $this->anotherStaffUser = User::factory()->create(['role' => 'staff']);
    }

    /** @test */
    public function admin_can_view_maintenance_requests_list()
    {
        // Create some maintenance requests
        MaintenanceRequest::factory()->count(3)->create();

        // Act as admin and visit the index page
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.maintenance-requests.index'));

        // Assert successful response and content
        $response->assertStatus(200);
        $response->assertViewIs('admin.maintenance_requests.index');
        $response->assertViewHas('maintenanceRequests');
    }

    /** @test */
    public function staff_can_view_only_their_maintenance_requests()
    {
        // Create maintenance requests for staff user
        $staffRequests = MaintenanceRequest::factory()->count(2)
            ->create(['requester_id' => $this->staffUser->id]);
        
        // Create maintenance requests for another user
        MaintenanceRequest::factory()->count(3)
            ->create(['requester_id' => $this->anotherStaffUser->id]);

        // Act as staff and visit the index page
        $response = $this->actingAs($this->staffUser)
            ->get(route('admin.maintenance-requests.index'));

        // Assert successful response
        $response->assertStatus(200);
        
        // Get the maintenance requests passed to the view
        $viewRequests = $response->viewData('maintenanceRequests');
        
        // Assert that only this staff user's requests are included
        $this->assertCount(2, $viewRequests);
        foreach ($viewRequests as $request) {
            $this->assertEquals($this->staffUser->id, $request->requester_id);
        }
    }

    /** @test */
    public function admin_can_create_maintenance_request()
    {
        $requestData = [
            'floor' => '3rd Floor',
            'location' => 'Room 305',
            'title' => 'Air Conditioning Issue',
            'description' => 'AC not cooling properly',
            'priority' => 'normal',
            'status' => 'new',
        ];

        // Act as admin and submit the form
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.maintenance-requests.store'), $requestData);

        // Assert redirection after successful creation
        $response->assertRedirect();
        
        // Assert the request was created with correct data
        $this->assertDatabaseHas('maintenance_requests', [
            'requester_id' => $this->adminUser->id,
            'floor' => '3rd Floor',
            'location' => 'Room 305',
            'title' => 'Air Conditioning Issue',
        ]);
    }

    /** @test */
    public function staff_can_create_maintenance_request()
    {
        $requestData = [
            'floor' => '1st Floor',
            'location' => 'Library',
            'title' => 'Broken Shelf',
            'description' => 'Bookshelf has collapsed',
            'priority' => 'urgent',
            'status' => 'new',
        ];

        // Act as staff and submit the form
        $response = $this->actingAs($this->staffUser)
            ->post(route('admin.maintenance-requests.store'), $requestData);

        // Assert redirection after successful creation
        $response->assertRedirect();
        
        // Assert the request was created with correct data and the requester_id is set
        $this->assertDatabaseHas('maintenance_requests', [
            'requester_id' => $this->staffUser->id,
            'floor' => '1st Floor',
            'location' => 'Library',
            'title' => 'Broken Shelf',
            'priority' => 'urgent',
        ]);
    }

    /** @test */
    public function admin_can_update_any_maintenance_request()
    {
        // Create a request by staff user
        $request = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
            'title' => 'Original Title',
            'status' => 'new',
        ]);

        $updateData = [
            'floor' => '2nd Floor',
            'location' => 'Computer Lab',
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'priority' => 'urgent',
            'status' => 'in_progress',
        ];

        // Act as admin and update the request
        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.maintenance-requests.update', $request), $updateData);

        // Assert redirection after successful update
        $response->assertRedirect();
        
        // Assert the request was updated
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $request->id,
            'title' => 'Updated Title',
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function staff_can_update_only_their_own_new_requests()
    {
        // Create a "new" request by the staff user
        $ownRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
            'title' => 'Staff Request',
            'status' => 'new',
        ]);

        // Create a request by another user
        $otherRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->anotherStaffUser->id,
            'title' => 'Other Staff Request',
            'status' => 'new',
        ]);

        // Create an in-progress request by the staff user
        $inProgressRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
            'title' => 'In Progress Request',
            'status' => 'in_progress',
        ]);

        $updateData = [
            'floor' => '1st Floor',
            'location' => 'Staff Room',
            'title' => 'Updated Staff Request',
            'description' => 'This is an update',
            'priority' => 'urgent',
            'status' => 'new',
        ];

        // 1. Staff updates their own "new" request - should succeed
        $response1 = $this->actingAs($this->staffUser)
            ->put(route('admin.maintenance-requests.update', $ownRequest), $updateData);
        $response1->assertRedirect();
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $ownRequest->id,
            'title' => 'Updated Staff Request',
        ]);

        // 2. Staff tries to update someone else's request - should fail
        $response2 = $this->actingAs($this->staffUser)
            ->put(route('admin.maintenance-requests.update', $otherRequest), $updateData);
        $response2->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('maintenance_requests', [
            'id' => $otherRequest->id,
            'title' => 'Updated Staff Request',
        ]);

        // 3. Staff tries to update their own "in_progress" request - should fail
        $response3 = $this->actingAs($this->staffUser)
            ->put(route('admin.maintenance-requests.update', $inProgressRequest), $updateData);
        $response3->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('maintenance_requests', [
            'id' => $inProgressRequest->id,
            'title' => 'Updated Staff Request',
        ]);
    }

    /** @test */
    public function admin_can_delete_maintenance_request()
    {
        // Create a request
        $request = MaintenanceRequest::factory()->create();

        // Act as admin and delete the request
        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.maintenance-requests.destroy', $request));

        // Assert redirection after successful deletion
        $response->assertRedirect();
        
        // Assert the request was deleted
        $this->assertDatabaseMissing('maintenance_requests', [
            'id' => $request->id,
        ]);
    }

    /** @test */
    public function staff_cannot_delete_maintenance_requests()
    {
        // Create a request by the staff user
        $request = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
        ]);

        // Act as staff and try to delete the request
        $response = $this->actingAs($this->staffUser)
            ->delete(route('admin.maintenance-requests.destroy', $request));

        // Assert forbidden status
        $response->assertStatus(403);
        
        // Assert the request was not deleted
        $this->assertDatabaseHas('maintenance_requests', [
            'id' => $request->id,
        ]);
    }

    /** @test */
    public function admin_can_view_any_maintenance_request_details()
    {
        // Create a request by staff user
        $request = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
        ]);

        // Act as admin and view the request
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.maintenance-requests.show', $request));

        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('admin.maintenance_requests.show');
        $response->assertViewHas('maintenanceRequest');
    }

    /** @test */
    public function staff_can_view_only_their_own_maintenance_request_details()
    {
        // Create a request by the staff user
        $ownRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staffUser->id,
            'title' => 'Staff Request',
        ]);

        // Create a request by another user
        $otherRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->anotherStaffUser->id,
            'title' => 'Other Staff Request',
        ]);

        // 1. Staff views their own request - should succeed
        $response1 = $this->actingAs($this->staffUser)
            ->get(route('admin.maintenance-requests.show', $ownRequest));
        $response1->assertStatus(200);
        $response1->assertViewIs('admin.maintenance_requests.show');

        // 2. Staff tries to view someone else's request - should fail
        $response2 = $this->actingAs($this->staffUser)
            ->get(route('admin.maintenance-requests.show', $otherRequest));
        $response2->assertStatus(403); // Forbidden
    }

    /** @test */
    public function requester_relationship_is_eager_loaded_in_index()
    {
        // Create some maintenance requests
        MaintenanceRequest::factory()->count(5)->create();

        // Enable query counting
        \DB::enableQueryLog();
        
        // Act as admin and visit the index page
        $this->actingAs($this->adminUser)
            ->get(route('admin.maintenance-requests.index'));
        
        // Get the executed queries
        $queries = \DB::getQueryLog();
        
        // We should have 2 queries:
        // 1. Select from maintenance_requests (with paginate)
        // 2. Select from users for eager loading
        // If N+1 problem exists, we'd have 1 + N queries (where N is number of requests)
        $this->assertLessThan(7, count($queries), 'N+1 query problem exists - requester relationship not properly eager loaded');
    }
} 