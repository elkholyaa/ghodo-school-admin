<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create material_requests table
 * 
 * This migration creates the table for storing material requests
 * submitted by users. It includes optional relationships to maintenance
 * requests and proper constraints for cost and funding sources.
 * 
 * Educational Note: This demonstrates nullable foreign keys and
 * how to handle optional relationships in database design.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to users table (requester)
            $table->foreignId('requester_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Optional foreign key to maintenance_requests table
            $table->foreignId('maintenance_request_id')
                  ->nullable()
                  ->constrained('maintenance_requests')
                  ->onDelete('set null');
            
            // Material details
            $table->string('item_description');
            $table->unsignedInteger('quantity');
            $table->decimal('cost', 8, 2)->nullable();
            
            // Funding source enum: school_budget, maintenance, other
            $table->enum('funding_source', ['school_budget', 'maintenance', 'other'])->nullable();
            
            // Status enum: pending (default), approved, rejected, fulfilled
            $table->enum('status', ['pending', 'approved', 'rejected', 'fulfilled'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
