<?php

use App\Http\Controllers\Web\AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');

// Admin Product Routes
Route::post('/admin/products', [AdminWebController::class, 'storeProduct'])->name('admin.products.store');
Route::put('/admin/products/{id}', [AdminWebController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [AdminWebController::class, 'destroyProduct'])->name('admin.products.destroy');
Route::post('/admin/products/{id}/stock', [AdminWebController::class, 'addStock'])->name('admin.products.stock');

// Admin Category Routes
Route::post('/admin/categories', [AdminWebController::class, 'storeCategory'])->name('admin.categories.store');
Route::put('/admin/categories/{id}', [AdminWebController::class, 'updateCategory'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminWebController::class, 'destroyCategory'])->name('admin.categories.destroy');

// Admin Order Routes
Route::patch('/admin/orders/{id}/status', [AdminWebController::class, 'updateOrderStatus'])->name('admin.orders.status');
