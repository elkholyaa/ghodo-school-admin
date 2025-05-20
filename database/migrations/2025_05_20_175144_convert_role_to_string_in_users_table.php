<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration ensures the 'role' column in the users table is a VARCHAR type.
     * If the column exists as an ENUM, it drops and recreates it as VARCHAR.
     * If it doesn't exist, it creates it as VARCHAR.
     * 
     * Using VARCHAR instead of ENUM provides better flexibility and follows Laravel best practices
     * by allowing role management at the application level via constants in the User model.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            // First, check the column type - this is database-specific
            $columnType = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'")[0]->Type;
            
            // If it's an ENUM, convert it to VARCHAR
            if (strpos($columnType, 'enum') === 0) {
                // Save existing role values
                $users = DB::table('users')->select('id')->addSelect(DB::raw('role as user_role'))->get();
                
                // Drop the ENUM column
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('role');
                });
                
                // Add new VARCHAR column
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role', 15)->default('staff')->after('civil_id');
                });
                
                // Restore the role values
                foreach ($users as $user) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['role' => $user->user_role]);
                }
            }
        } else {
            // Add the role column if it doesn't exist
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 15)->default('staff')->after('civil_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     * 
     * This method doesn't necessarily convert back to ENUM since it's better to
     * keep using the string type for flexibility.
     */
    public function down(): void
    {
        // No need to revert to ENUM as string is preferred
    }
};
