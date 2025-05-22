<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestHelpers;

/**
 * Unit tests for the User model.
 * 
 * These tests verify that the User model's methods work correctly
 * in isolation, following Laravel testing best practices.
 */
class UserModelTest extends TestCase
{
    use RefreshDatabase, TestHelpers;

    /**
     * Test that isAdmin returns true for admin users.
     *
     * @return void
     */
    public function test_is_admin_returns_true_for_admin_role()
    {
        // Create an admin user using our helper method
        // which follows best practices for test data creation
        $user = $this->createAdminUser();
        
        // Verify the isAdmin method returns true
        $this->assertTrue($user->isAdmin());
    }

    /**
     * Test that isAdmin returns false for staff users.
     *
     * @return void
     */
    public function test_is_admin_returns_false_for_staff_role()
    {
        // Create a staff user using our helper method
        $user = $this->createUser('staff');
        
        // Verify the isAdmin method returns false
        $this->assertFalse($user->isAdmin());
    }

    /**
     * Test that the User model attributes are properly fillable.
     *
     * @return void
     */
    public function test_user_attributes_are_fillable()
    {
        // Create a user with all fillable attributes
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'phone' => '123456789',
            'civil_id' => 'ABC123456'
        ];
        
        $user = User::create($userData);
        
        // Verify all attributes were saved correctly
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('staff', $user->role);
        $this->assertEquals('123456789', $user->phone);
        $this->assertEquals('ABC123456', $user->civil_id);
    }
} 