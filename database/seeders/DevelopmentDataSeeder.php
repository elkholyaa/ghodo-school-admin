<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\MaterialRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * DevelopmentDataSeeder - Seeds the database with realistic development data
 * 
 * This seeder creates:
 * - Admin and staff users with known credentials for development
 * - Sample maintenance requests in various statuses
 * - Sample material requests linked to maintenance requests and standalone
 * 
 * Educational Note: Seeders are essential for development as they provide
 * consistent, realistic data for testing features and UI components.
 */
class DevelopmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create development users with known credentials
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@ghodo.test',
            'phone' => '966501234567',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $staff1 = User::create([
            'name' => 'أحمد محمد',
            'email' => 'ahmed@ghodo.test',
            'phone' => '966507654321',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $staff2 = User::create([
            'name' => 'فاطمة علي',
            'email' => 'fatima@ghodo.test',
            'phone' => '966509876543',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create additional random staff users
        $additionalStaff = User::factory()->count(8)->create([
            'role' => 'staff',
        ]);

        // Collect all users for creating requests
        $allUsers = collect([$admin, $staff1, $staff2])->merge($additionalStaff);

        // Create maintenance requests with various statuses
        
        // New maintenance requests (pending)
        MaintenanceRequest::create([
            'requester_id' => $staff1->id,
            'floor' => 'الطابق الأول',
            'location' => 'غرفة 101',
            'title' => 'إصلاح النافذة المكسورة',
            'description' => 'النافذة في غرفة 101 بها كسر في الزجاج ويحتاج إلى استبدال',
            'priority' => 'urgent',
            'status' => 'new',
            'created_at' => now()->subDays(2),
        ]);

        MaintenanceRequest::create([
            'requester_id' => $staff2->id,
            'floor' => 'الطابق الثاني',
            'location' => 'المختبر A',
            'title' => 'مشكلة في التكييف',
            'description' => 'التكييف لا يعمل بشكل صحيح في المختبر A',
            'priority' => 'normal',
            'status' => 'new',
            'created_at' => now()->subDays(1),
        ]);

        // In-progress maintenance requests
        MaintenanceRequest::create([
            'requester_id' => $admin->id,
            'floor' => 'الطابق الأرضي',
            'location' => 'القاعة الرئيسية',
            'title' => 'إصلاح الإضاءة',
            'description' => 'بعض المصابيح في القاعة الرئيسية لا تعمل',
            'priority' => 'normal',
            'status' => 'in_progress',
            'created_at' => now()->subDays(5),
        ]);

        $inProgressRequest = MaintenanceRequest::create([
            'requester_id' => $staff1->id,
            'floor' => 'الطابق الثاني',
            'location' => 'غرفة المعلمين',
            'title' => 'إصلاح مقبض الباب',
            'description' => 'مقبض الباب مكسور ويحتاج إلى استبدال',
            'priority' => 'normal',
            'status' => 'in_progress',
            'created_at' => now()->subDays(3),
        ]);

        // Completed maintenance requests
        MaintenanceRequest::create([
            'requester_id' => $staff2->id,
            'floor' => 'الطابق الأول',
            'location' => 'المكتبة',
            'title' => 'طلاء الجدران',
            'description' => 'إعادة طلاء جدران المكتبة',
            'priority' => 'normal',
            'status' => 'completed',
            'created_at' => now()->subWeeks(2),
        ]);

        // Create additional random maintenance requests
        MaintenanceRequest::factory()->count(15)->create([
            'requester_id' => $allUsers->random()->id,
        ]);

        // Create material requests

        // Pending material requests linked to maintenance
        MaterialRequest::create([
            'requester_id' => $staff1->id,
            'maintenance_request_id' => $inProgressRequest->id,
            'item_description' => 'مقبض باب نحاسي',
            'quantity' => 1,
            'cost' => 75.00,
            'funding_source' => 'maintenance',
            'status' => 'pending',
            'created_at' => now()->subDays(2),
        ]);

        MaterialRequest::create([
            'requester_id' => $staff2->id,
            'maintenance_request_id' => null, // Standalone request
            'item_description' => 'مصابيح LED 60 واط (عبوة 10 قطع)',
            'quantity' => 2,
            'cost' => 180.00,
            'funding_source' => 'school_budget',
            'status' => 'pending',
            'created_at' => now()->subDays(1),
        ]);

        MaterialRequest::create([
            'requester_id' => $admin->id,
            'maintenance_request_id' => null,
            'item_description' => 'أدوات تنظيف متنوعة',
            'quantity' => 1,
            'cost' => 120.00,
            'funding_source' => 'school_budget',
            'status' => 'pending',
            'created_at' => now()->subHours(12),
        ]);

        // Approved material requests
        MaterialRequest::create([
            'requester_id' => $staff1->id,
            'maintenance_request_id' => null,
            'item_description' => 'طلاء أبيض (4 جالون)',
            'quantity' => 4,
            'cost' => 320.00,
            'funding_source' => 'maintenance',
            'status' => 'approved',
            'created_at' => now()->subDays(7),
        ]);

        // Create additional random material requests
        MaterialRequest::factory()->count(20)->create([
            'requester_id' => $allUsers->random()->id,
        ]);

        $this->command->info('Development data seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@ghodo.test / password');
        $this->command->info('Staff 1: ahmed@ghodo.test / password');
        $this->command->info('Staff 2: fatima@ghodo.test / password');
    }
}
