<?php

namespace Tests;

/**
 * Test Helpers for Ghodo School Admin
 * 
 * This file contains helper methods for testing following Laravel best practices.
 * Instead of directly accessing environment variables, we use Laravel's configuration system.
 */
trait TestHelpers
{
    /**
     * Get database configuration using Laravel's config system
     * Best practice: Use Laravel's config() helper instead of reading .env directly
     * 
     * @return array
     */
    public function getDatabaseConfig(): array
    {
        return [
            'connection' => config('database.default'),
            'database' => config('database.connections.' . config('database.default') . '.database'),
            'username' => config('database.connections.' . config('database.default') . '.username'),
        ];
    }
    
    /**
     * Create a user with the given role
     * Best practice: Use factories for test data
     * 
     * @param string $role
     * @return \App\Models\User
     */
    public function createUser(string $role = 'staff')
    {
        return \App\Models\User::factory()->create([
            'role' => $role,
        ]);
    }
    
    /**
     * Create an admin user
     * Best practice: Create helper methods for common test setups
     * 
     * @return \App\Models\User
     */
    public function createAdminUser()
    {
        return $this->createUser('admin');
    }
} 