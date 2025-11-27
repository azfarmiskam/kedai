<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\NotificationSettingsController;

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
