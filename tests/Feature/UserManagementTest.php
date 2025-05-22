<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase; // This will reset the database after each test

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user for testing
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin_test@example.com'
        ]);
        
        // Create a staff user for testing
        $this->staff = User::factory()->create([
            'role' => 'staff',
            'email' => 'staff_test@example.com'
        ]);
    }

    /** @test */
    public function admin_can_view_users_list()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.users.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
        $response->assertSee($this->admin->name);
        $response->assertSee($this->staff->name);
    }
    
    /** @test */
    public function staff_cannot_view_users_list()
    {
        $response = $this->actingAs($this->staff)
                         ->get(route('admin.users.index'));
        
        $response->assertStatus(403); // Forbidden
    }
    
    /** @test */
    public function admin_can_view_create_user_form()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.users.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
    }
    
    /** @test */
    public function admin_can_create_user()
    {
        $userData = [
            'name' => 'New Test User',
            'email' => 'new_test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'staff',
            'phone' => '1234567890',
            'civil_id' => 'ABC123456'
        ];
        
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.users.store'), $userData);
        
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('users', [
            'name' => 'New Test User',
            'email' => 'new_test@example.com',
            'role' => 'staff',
            'phone' => '1234567890',
            'civil_id' => 'ABC123456'
        ]);
    }
    
    /** @test */
    public function admin_can_view_edit_user_form()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.users.edit', $this->staff));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user');
        $response->assertSee($this->staff->name);
    }
    
    /** @test */
    public function admin_can_update_user()
    {
        $updatedData = [
            'name' => 'Updated User Name',
            'email' => $this->staff->email, // Keep the same email
            'role' => 'staff',
            'phone' => '9876543210',
            'civil_id' => 'XYZ987654'
        ];
        
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.users.update', $this->staff), $updatedData);
        
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('users', [
            'id' => $this->staff->id,
            'name' => 'Updated User Name',
            'phone' => '9876543210',
            'civil_id' => 'XYZ987654'
        ]);
    }
    
    /** @test */
    public function admin_can_update_user_password()
    {
        $updatedData = [
            'name' => $this->staff->name,
            'email' => $this->staff->email,
            'role' => 'staff',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];
        
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.users.update', $this->staff), $updatedData);
        
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
    }
    
    /** @test */
    public function admin_can_delete_other_users()
    {
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.users.destroy', $this->staff));
        
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('users', [
            'id' => $this->staff->id
        ]);
    }
    
    /** @test */
    public function admin_cannot_delete_self()
    {
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.users.destroy', $this->admin));
        
        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id
        ]);
    }
    
    /** @test */
    public function staff_cannot_access_user_management()
    {
        // Staff trying to access various user management routes
        $routes = [
            route('admin.users.index'),
            route('admin.users.create'),
            route('admin.users.edit', $this->admin),
            route('admin.users.show', $this->admin),
        ];
        
        foreach ($routes as $route) {
            $response = $this->actingAs($this->staff)->get($route);
            $response->assertStatus(403); // Forbidden
        }
        
        // Staff trying to create a user
        $response = $this->actingAs($this->staff)
                         ->post(route('admin.users.store'), [
                             'name' => 'Staff Created User',
                             'email' => 'staff_created@example.com',
                             'password' => 'password',
                             'password_confirmation' => 'password',
                             'role' => 'staff'
                         ]);
        $response->assertStatus(403);
        
        // Staff trying to update a user
        $response = $this->actingAs($this->staff)
                         ->put(route('admin.users.update', $this->admin), [
                             'name' => 'Changed By Staff',
                             'email' => $this->admin->email,
                             'role' => 'staff' // Trying to demote admin
                         ]);
        $response->assertStatus(403);
        
        // Staff trying to delete a user
        $response = $this->actingAs($this->staff)
                         ->delete(route('admin.users.destroy', $this->admin));
        $response->assertStatus(403);
    }
}
