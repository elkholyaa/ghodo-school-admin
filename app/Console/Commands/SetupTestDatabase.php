<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

/**
 * SetupTestDatabase Command
 * 
 * This command sets up a separate test database to ensure tests don't
 * interfere with development data. It creates the database if it doesn't
 * exist and runs migrations.
 * 
 * Educational Note: Separating test and development databases is a best
 * practice that ensures test isolation while preserving development data.
 */
class SetupTestDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:setup {--migrate : Run migrations on test database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the test database and optionally run migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up test database...');
        
        try {
            // Get current database connection settings
            $connection = config('database.default');
            $database = config('database.connections.' . $connection . '.database');
            $testDatabase = 'ghodo_admin_test';
            
            // Create test database if it doesn't exist
            config(['database.connections.' . $connection . '.database' => null]);
            DB::reconnect();
            
            $this->info("Creating test database '{$testDatabase}' if it doesn't exist...");
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$testDatabase}`");
            
            // Switch to test database
            config(['database.connections.' . $connection . '.database' => $testDatabase]);
            DB::reconnect();
            
            $this->info('Test database created successfully!');
            
            // Run migrations if requested
            if ($this->option('migrate')) {
                $this->info('Running migrations on test database...');
                Artisan::call('migrate:fresh', ['--force' => true]);
                $this->info('Test database migrations completed!');
            }
            
            // Switch back to original database
            config(['database.connections.' . $connection . '.database' => $database]);
            DB::reconnect();
            
            $this->info('✅ Test database setup complete!');
            $this->info('');
            $this->info('📋 Usage:');
            $this->info('  • Development DB: ' . $database);
            $this->info('  • Test DB: ' . $testDatabase);
            $this->info('  • Tests will now use the separate test database');
            $this->info('  • Your development data is preserved');
            
        } catch (\Exception $e) {
            $this->error('Failed to set up test database: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
