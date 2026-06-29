<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\RedirectUserController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\Rider\RiderDashboardController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Auth::routes();

// ==========================================
// ROLE-BASED REDIRECT AFTER LOGIN
// ==========================================
Route::get('/dashboard', RedirectUserController::class)->name('dashboard');

// ==========================================
// CUSTOMER ROUTES
// ==========================================
Route::middleware(['auth', 'role:Customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/orders', [CustomerDashboardController::class, 'storeOrder'])->name('orders.store');
    Route::get('/orders/{order}/track', [CustomerDashboardController::class, 'trackOrder'])->name('orders.track');
    Route::post('/orders/{order}/rate', [CustomerDashboardController::class, 'rateVendor'])->name('orders.rate');
    Route::post('/orders/{order}/message', [CustomerDashboardController::class, 'sendMessage'])->name('orders.message');
    Route::get('/orders/{order}/reorder', [CustomerDashboardController::class, 'reorder'])->name('orders.reorder');
});

// ==========================================
// VENDOR ROUTES
// ==========================================
Route::middleware(['auth', 'role:Vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::post('/orders/{order}/accept', [VendorDashboardController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/orders/{order}/status', [VendorDashboardController::class, 'updateStatus'])->name('orders.status');
    Route::get('/earnings', [VendorDashboardController::class, 'earnings'])->name('earnings');
});

// ==========================================
// RIDER ROUTES
// ==========================================
Route::middleware(['auth', 'role:Rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'index'])->name('dashboard');
    Route::post('/toggle-availability', [RiderDashboardController::class, 'toggleAvailability'])->name('toggle-availability');
    Route::post('/order/{order}/handshake', [RiderDashboardController::class, 'handshake'])->name('order.handshake');
    Route::post('/order/{order}/transition', [RiderDashboardController::class, 'updateStatus'])->name('order.transition');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::post('/users/{user}/approve', [AdminDashboardController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminDashboardController::class, 'rejectUser'])->name('users.reject');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
    Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments.index');
});

// ==========================================
// M-PESA ROUTES
// ==========================================
Route::post('/api/v1/mpesa/stk-push', [MpesaController::class, 'initiateStkPush'])->name('mpesa.stk');
Route::post('/api/v1/mpesa/callback', [MpesaController::class, 'processCallback'])->name('mpesa.callback');

// ==========================================
// FALLBACK
// ==========================================
Route::fallback(function () {
    return redirect()->route('dashboard');
});