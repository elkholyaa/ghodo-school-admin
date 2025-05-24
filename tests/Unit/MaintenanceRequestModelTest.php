<?php

namespace Tests\Unit;

use App\Models\MaintenanceRequest;
use App\Models\MaterialRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * MaintenanceRequestModelTest - Unit Testing for MaintenanceRequest Model
 * 
 * This test class verifies the MaintenanceRequest model functionality:
 * - Tests fillable attributes are correctly defined
 * - Verifies Eloquent relationships work properly
 * - Tests model behavior and methods
 * 
 * Educational Note: Unit tests focus on testing individual components
 * in isolation, ensuring models behave correctly at the code level.
 */
class MaintenanceRequestModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that MaintenanceRequest model has correct fillable attributes
     */
    public function test_maintenance_request_has_correct_fillable_attributes(): void
    {
        $maintenanceRequest = new MaintenanceRequest();
        
        $expectedFillable = [
            'requester_id',
            'floor',
            'location',
            'title',
            'description',
            'priority',
            'status',
        ];
        
        $this->assertEquals($expectedFillable, $maintenanceRequest->getFillable());
    }

    /**
     * Test that MaintenanceRequest can be created with fillable attributes
     */
    public function test_maintenance_request_can_be_created_with_fillable_data(): void
    {
        $user = User::factory()->create();
        
        $data = [
            'requester_id' => $user->id,
            'floor' => '2nd Floor',
            'location' => 'Room 201',
            'title' => 'Broken Window',
            'description' => 'The window in room 201 is cracked and needs repair',
            'priority' => 'urgent',
            'status' => 'new',
        ];
        
        $maintenanceRequest = MaintenanceRequest::create($data);
        
        $this->assertInstanceOf(MaintenanceRequest::class, $maintenanceRequest);
        $this->assertEquals($data['requester_id'], $maintenanceRequest->requester_id);
        $this->assertEquals($data['floor'], $maintenanceRequest->floor);
        $this->assertEquals($data['location'], $maintenanceRequest->location);
        $this->assertEquals($data['title'], $maintenanceRequest->title);
        $this->assertEquals($data['description'], $maintenanceRequest->description);
        $this->assertEquals($data['priority'], $maintenanceRequest->priority);
        $this->assertEquals($data['status'], $maintenanceRequest->status);
    }

    /**
     * Test MaintenanceRequest belongs to a User (requester relationship)
     */
    public function test_maintenance_request_belongs_to_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
        
        $maintenanceRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $user->id,
            'title' => 'Test Request'
        ]);
        
        // Test the relationship
        $this->assertInstanceOf(User::class, $maintenanceRequest->requester);
        $this->assertEquals($user->id, $maintenanceRequest->requester->id);
        $this->assertEquals('Test User', $maintenanceRequest->requester->name);
    }

    /**
     * Test MaintenanceRequest has many MaterialRequests relationship
     */
    public function test_maintenance_request_has_many_material_requests(): void
    {
        $user = User::factory()->create();
        
        $maintenanceRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $user->id,
            'title' => 'Test Request'
        ]);
        
        // Create material requests associated with this maintenance request
        $materialRequest1 = MaterialRequest::factory()->create([
            'maintenance_request_id' => $maintenanceRequest->id,
            'requester_id' => $user->id,
            'item_description' => 'Paint'
        ]);
        
        $materialRequest2 = MaterialRequest::factory()->create([
            'maintenance_request_id' => $maintenanceRequest->id,
            'requester_id' => $user->id,
            'item_description' => 'Brush'
        ]);
        
        // Test the relationship
        $this->assertCount(2, $maintenanceRequest->materialRequests);
        $this->assertInstanceOf(MaterialRequest::class, $maintenanceRequest->materialRequests->first());
        $this->assertEquals('Paint', $maintenanceRequest->materialRequests->first()->item_description);
    }

    /**
     * Test MaintenanceRequest model uses HasFactory trait
     */
    public function test_maintenance_request_uses_has_factory_trait(): void
    {
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(MaintenanceRequest::class)
        );
    }

    /**
     * Test MaintenanceRequest model extends Model
     */
    public function test_maintenance_request_extends_model(): void
    {
        $maintenanceRequest = new MaintenanceRequest();
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $maintenanceRequest);
    }

    /**
     * Test that creating maintenance request with invalid user ID throws constraint violation
     */
    public function test_maintenance_request_requester_returns_null_for_invalid_user(): void
    {
        // Test that foreign key constraint prevents creating with invalid user ID
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        MaintenanceRequest::factory()->create([
            'requester_id' => 999999, // Non-existent user ID
            'title' => 'Test Request'
        ]);
    }

    /**
     * Test MaintenanceRequest timestamps are automatically managed
     */
    public function test_maintenance_request_has_timestamps(): void
    {
        $user = User::factory()->create();
        
        $maintenanceRequest = MaintenanceRequest::create([
            'requester_id' => $user->id,
            'location' => 'Test Location',
            'title' => 'Test Title',
            'priority' => 'normal',
            'status' => 'new',
        ]);
        
        $this->assertNotNull($maintenanceRequest->created_at);
        $this->assertNotNull($maintenanceRequest->updated_at);
        $this->assertInstanceOf('Carbon\Carbon', $maintenanceRequest->created_at);
        $this->assertInstanceOf('Carbon\Carbon', $maintenanceRequest->updated_at);
    }
}
