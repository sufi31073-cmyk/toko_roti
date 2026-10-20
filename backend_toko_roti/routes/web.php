<?php

use App\Http\Controllers\Web\AdminLoginController;
use App\Http\Controllers\Web\AdminWebController;
use Illuminate\Support\Facades\Route;

// ─── Root Redirect ─────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect('/admin');
});

// ─── Admin Auth Routes (guest only) ────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
});

// Admin Logout (any authenticated user)
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ─── Protected Admin Routes ─────────────────────────────────────────────────
Route::middleware(\App\Http\Middleware\AdminWebMiddleware::class)->group(function () {

    // Dashboard
    Route::get('/admin', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');

    // Product Routes
    Route::post('/admin/products', [AdminWebController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/admin/products/{id}', [AdminWebController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminWebController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::post('/admin/products/{id}/stock', [AdminWebController::class, 'addStock'])->name('admin.products.stock');

    // Category Routes
    Route::post('/admin/categories', [AdminWebController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/admin/categories/{id}', [AdminWebController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [AdminWebController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Order Routes
    Route::patch('/admin/orders/{id}/status', [AdminWebController::class, 'updateOrderStatus'])->name('admin.orders.status');
});
