<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * This method calls the UserSeeder to create the necessary users
     * for the ghodo-school-admin application.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
    }
}
