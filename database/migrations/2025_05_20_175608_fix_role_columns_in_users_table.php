<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration cleans up the users table by ensuring there is only one role column
     * of type varchar/string, and no temporary columns remain. It transfers any values
     * from role_temp to role if needed.
     */
    public function up(): void
    {
        // Check if both columns exist
        $hasRole = Schema::hasColumn('users', 'role');
        $hasRoleTemp = Schema::hasColumn('users', 'role_temp');
        
        if ($hasRole && $hasRoleTemp) {
            // Update the main role column with values from role_temp where appropriate
            $users = DB::table('users')->whereNotNull('role_temp')->get();
            foreach ($users as $user) {
                if ($user->role_temp === 'admin') {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['role' => 'admin']);
                }
            }
            
            // Drop the temporary column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_temp');
            });
        }
        
        // Ensure the role column is of the right type if it exists
        if ($hasRole) {
            $columnInfo = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'")[0];
            
            // If it's an enum type, convert it to varchar
            if (strpos($columnInfo->Type, 'enum') === 0) {
                // Save the current values
                $users = DB::table('users')->select('id')->addSelect(DB::raw('role as user_role'))->get();
                
                // Drop and recreate the column
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('role');
                });
                
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role', 15)->default('staff')->after('civil_id');
                });
                
                // Restore the values
                foreach ($users as $user) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['role' => $user->user_role]);
                }
            }
        } else {
            // Add the role column if it doesn't exist at all
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 15)->default('staff')->after('civil_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     * 
     * This is a cleanup migration, so there's no meaningful way to roll it back.
     */
    public function down(): void
    {
        // No rollback needed for this cleanup migration
    }
};
