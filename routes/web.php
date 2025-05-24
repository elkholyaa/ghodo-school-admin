<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User management routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->middleware('is_admin');
    
    // Maintenance request management routes
    Route::resource('maintenance-requests', App\Http\Controllers\Admin\MaintenanceRequestController::class);
    
    // Material Requests CRUD
    Route::resource('material-requests', App\Http\Controllers\Admin\MaterialRequestController::class);
    
    // Other admin resource routes will also go in this group
});

require __DIR__.'/auth.php';
