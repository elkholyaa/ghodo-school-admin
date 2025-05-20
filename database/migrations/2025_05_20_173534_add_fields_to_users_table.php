<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds additional user information fields and a role field 
     * to the users table for the ghodo-school-admin application, if they don't already exist.
     * 
     * The fields added are:
     * - phone: A nullable string for storing the user's phone number
     * - civil_id: A nullable string for storing the user's civil identification number
     * - role: A string field to define user roles with 'staff' as default
     * 
     * Note: Using a string column for roles instead of ENUM provides better flexibility
     * and avoids database-level constraints, following Laravel best practices.
     * Role validation is handled at the application level through the User model.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add phone field if it doesn't exist
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            
            // Add civil_id field if it doesn't exist
            if (!Schema::hasColumn('users', 'civil_id')) {
                $table->string('civil_id', 30)->nullable()->after('phone');
            }
            
            // Add role field if it doesn't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 15)->default('staff')->after('civil_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     * 
     * This method will remove all columns added by this migration,
     * restoring the users table to its previous state.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns if they exist
            $columns = ['phone', 'civil_id', 'role'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
