<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create maintenance_requests table
 * 
 * This migration creates the table for storing maintenance requests
 * submitted by users (admin/staff). It includes relationships to users
 * and proper enum constraints for priority and status fields.
 * 
 * Educational Note: This demonstrates proper migration structure with
 * foreign keys, enum constraints, and nullable fields for optional data.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to users table (requester)
            $table->foreignId('requester_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Request details
            $table->string('floor')->nullable();
            $table->string('location');
            $table->string('title');
            $table->text('description')->nullable();
            
            // Priority enum: normal (default), urgent
            $table->enum('priority', ['normal', 'urgent'])->default('normal');
            
            // Status enum: new (default), in_progress, completed, transferred
            $table->enum('status', ['new', 'in_progress', 'completed', 'transferred'])->default('new');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
