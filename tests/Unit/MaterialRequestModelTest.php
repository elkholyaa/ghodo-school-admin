<?php

namespace Tests\Unit;

use App\Models\MaterialRequest;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * MaterialRequestModelTest - Unit Testing for MaterialRequest Model
 * 
 * This test class verifies the MaterialRequest model functionality:
 * - Tests fillable attributes are correctly defined
 * - Verifies Eloquent relationships work properly (including nullable ones)
 * - Tests model behavior and methods
 * 
 * Educational Note: This demonstrates testing nullable relationships
 * and how to handle optional foreign key constraints in Eloquent models.
 */
class MaterialRequestModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that MaterialRequest model has correct fillable attributes
     */
    public function test_material_request_has_correct_fillable_attributes(): void
    {
        $materialRequest = new MaterialRequest();
        
        $expectedFillable = [
            'requester_id',
            'maintenance_request_id',
            'item_description',
            'quantity',
            'cost',
            'funding_source',
            'status',
        ];
        
        $this->assertEquals($expectedFillable, $materialRequest->getFillable());
    }

    /**
     * Test that MaterialRequest can be created with fillable attributes
     */
    public function test_material_request_can_be_created_with_fillable_data(): void
    {
        $user = User::factory()->create();
        $maintenanceRequest = MaintenanceRequest::factory()->create(['requester_id' => $user->id]);
        
        $data = [
            'requester_id' => $user->id,
            'maintenance_request_id' => $maintenanceRequest->id,
            'item_description' => 'Paint for walls',
            'quantity' => 5,
            'cost' => 150.50,
            'funding_source' => 'school_budget',
            'status' => 'pending',
        ];
        
        $materialRequest = MaterialRequest::create($data);
        
        $this->assertInstanceOf(MaterialRequest::class, $materialRequest);
        $this->assertEquals($data['requester_id'], $materialRequest->requester_id);
        $this->assertEquals($data['maintenance_request_id'], $materialRequest->maintenance_request_id);
        $this->assertEquals($data['item_description'], $materialRequest->item_description);
        $this->assertEquals($data['quantity'], $materialRequest->quantity);
        $this->assertEquals($data['cost'], $materialRequest->cost);
        $this->assertEquals($data['funding_source'], $materialRequest->funding_source);
        $this->assertEquals($data['status'], $materialRequest->status);
    }

    /**
     * Test MaterialRequest belongs to a User (requester relationship)
     */
    public function test_material_request_belongs_to_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
        
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $user->id,
            'item_description' => 'Test Item'
        ]);
        
        // Test the relationship
        $this->assertInstanceOf(User::class, $materialRequest->requester);
        $this->assertEquals($user->id, $materialRequest->requester->id);
        $this->assertEquals('Test User', $materialRequest->requester->name);
    }

    /**
     * Test MaterialRequest optionally belongs to MaintenanceRequest
     */
    public function test_material_request_belongs_to_maintenance_request(): void
    {
        $user = User::factory()->create();
        $maintenanceRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $user->id,
            'title' => 'Test Maintenance Request'
        ]);
        
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $user->id,
            'maintenance_request_id' => $maintenanceRequest->id,
            'item_description' => 'Test Item'
        ]);
        
        // Test the relationship
        $this->assertInstanceOf(MaintenanceRequest::class, $materialRequest->maintenanceRequest);
        $this->assertEquals($maintenanceRequest->id, $materialRequest->maintenanceRequest->id);
        $this->assertEquals('Test Maintenance Request', $materialRequest->maintenanceRequest->title);
    }

    /**
     * Test MaterialRequest can exist without MaintenanceRequest (nullable relationship)
     */
    public function test_material_request_can_exist_without_maintenance_request(): void
    {
        $user = User::factory()->create();
        
        $materialRequest = MaterialRequest::factory()->create([
            'requester_id' => $user->id,
            'maintenance_request_id' => null, // No associated maintenance request
            'item_description' => 'Standalone Material Request'
        ]);
        
        // Test that the relationship returns null
        $this->assertNull($materialRequest->maintenanceRequest);
        $this->assertNotNull($materialRequest->requester); // But requester should still exist
    }

    /**
     * Test MaterialRequest model uses HasFactory trait
     */
    public function test_material_request_uses_has_factory_trait(): void
    {
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(MaterialRequest::class)
        );
    }

    /**
     * Test MaterialRequest model extends Model
     */
    public function test_material_request_extends_model(): void
    {
        $materialRequest = new MaterialRequest();
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $materialRequest);
    }

    /**
     * Test MaterialRequest can be created with minimal required data
     */
    public function test_material_request_can_be_created_with_minimal_data(): void
    {
        $user = User::factory()->create();
        
        $data = [
            'requester_id' => $user->id,
            'item_description' => 'Basic Item',
            'quantity' => 1,
            'status' => 'pending',
        ];
        
        $materialRequest = MaterialRequest::create($data);
        
        $this->assertInstanceOf(MaterialRequest::class, $materialRequest);
        $this->assertEquals($data['item_description'], $materialRequest->item_description);
        $this->assertEquals($data['quantity'], $materialRequest->quantity);
        $this->assertNull($materialRequest->cost);
        $this->assertNull($materialRequest->funding_source);
        $this->assertNull($materialRequest->maintenance_request_id);
    }

    /**
     * Test that creating material request with invalid IDs throws constraint violation
     */
    public function test_material_request_relationships_handle_invalid_ids(): void
    {
        // Test that foreign key constraint prevents creating with invalid user ID
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        MaterialRequest::factory()->create([
            'requester_id' => 999999, // Non-existent user ID
            'maintenance_request_id' => 999999, // Non-existent maintenance request ID
            'item_description' => 'Test Item'
        ]);
    }

    /**
     * Test MaterialRequest timestamps are automatically managed
     */
    public function test_material_request_has_timestamps(): void
    {
        $user = User::factory()->create();
        
        $materialRequest = MaterialRequest::create([
            'requester_id' => $user->id,
            'item_description' => 'Test Item',
            'quantity' => 1,
            'status' => 'pending',
        ]);
        
        $this->assertNotNull($materialRequest->created_at);
        $this->assertNotNull($materialRequest->updated_at);
        $this->assertInstanceOf('Carbon\Carbon', $materialRequest->created_at);
        $this->assertInstanceOf('Carbon\Carbon', $materialRequest->updated_at);
    }

    /**
     * Test MaterialRequest can handle different funding sources
     */
    public function test_material_request_accepts_valid_funding_sources(): void
    {
        $user = User::factory()->create();
        
        $validSources = ['school_budget', 'maintenance', 'other'];
        
        foreach ($validSources as $source) {
            $materialRequest = MaterialRequest::create([
                'requester_id' => $user->id,
                'item_description' => "Item for {$source}",
                'quantity' => 1,
                'funding_source' => $source,
                'status' => 'pending',
            ]);
            
            $this->assertEquals($source, $materialRequest->funding_source);
        }
    }
}
