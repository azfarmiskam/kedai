<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\NotificationSettingsController;
use App\Http\Controllers\SuperAdmin\AdminController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Super Admin routes
    Route::prefix('superadmin')->middleware('role:superadmin')->group(function () {
        Route::get('/dashboard', function () {
            return view('superadmin.dashboard');
        })->name('superadmin.dashboard');
        
        // Admin Management - Explicit routes with plural naming
        Route::get('/admins', [AdminController::class, 'index'])->name('superadmin.admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('superadmin.admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('superadmin.admins.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('superadmin.admins.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('superadmin.admins.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('superadmin.admins.destroy');
        Route::post('/admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('superadmin.admins.toggle-status');
        
        // Notification Settings
        Route::get('/settings/notifications', [NotificationSettingsController::class, 'index'])->name('superadmin.settings.notifications');
        Route::put('/settings/notifications', [NotificationSettingsController::class, 'update'])->name('superadmin.settings.notifications.update');
        Route::post('/settings/notifications/test-telegram', [NotificationSettingsController::class, 'testTelegram'])->name('superadmin.settings.notifications.test-telegram');
        Route::post('/settings/notifications/test-whatsapp', [NotificationSettingsController::class, 'testWhatsApp'])->name('superadmin.settings.notifications.test-whatsapp');
    });

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return 'Admin Dashboard';
        })->name('admin.dashboard');
    });

    // Seller routes
    Route::prefix('seller')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', function () {
            return 'Seller Dashboard';
        })->name('seller.dashboard');
    });

    // Buyer routes
    Route::prefix('buyer')->middleware('role:buyer')->group(function () {
        Route::get('/dashboard', function () {
            return 'Buyer Dashboard';
        })->name('buyer.dashboard');
    });
});
