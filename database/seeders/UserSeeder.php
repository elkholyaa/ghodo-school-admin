<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates test users with different roles for the ghodo-school-admin application.
     * - One administrator user with full access rights
     * - One staff user with limited access rights
     * 
     * These users can be used for testing and development purposes.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ghodoschool.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'civil_id' => 'A123456789',
            'role' => User::ROLE_ADMIN,
        ]);

        // Create a staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@ghodoschool.com',
            'password' => Hash::make('password'),
            'phone' => '+9876543210',
            'civil_id' => 'S987654321',
            'role' => User::ROLE_STAFF,
        ]);
    }
}
