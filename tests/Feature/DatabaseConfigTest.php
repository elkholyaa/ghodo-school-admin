<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestHelpers;

/**
 * Test to verify database configuration is working properly
 * This follows Laravel best practices by using Laravel's configuration system
 * instead of accessing .env directly
 */
class DatabaseConfigTest extends TestCase
{
    use TestHelpers;

    /**
     * Test that the database connection is configured correctly
     */
    public function test_database_connection_is_mysql()
    {
        // Use Laravel's config system to check database configuration
        $connection = config('database.default');
        $this->assertEquals('mysql', $connection);
        
        // Check database name through Laravel's config system
        $database = config('database.connections.mysql.database');
        $this->assertEquals('ghodo_admin_db', $database);
        
        // Verify we can connect to the database
        $this->assertTrue(\Illuminate\Support\Facades\DB::connection()->getPdo() !== null);
    }
    
    /**
     * Test that we can perform a simple query on the database
     */
    public function test_can_query_database()
    {
        // Simple query to verify database access
        $result = \Illuminate\Support\Facades\DB::select('SELECT 1 as test');
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0]->test);
    }
} 