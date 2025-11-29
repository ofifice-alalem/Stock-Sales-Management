<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        
        // Product price management
        Route::get('products/manage-prices', [\App\Http\Controllers\Admin\ProductController::class, 'managePrices'])->name('products.manage-prices');
        Route::post('products/update-zero-prices', [\App\Http\Controllers\ProductPriceController::class, 'updateZeroPrices'])->name('products.update-zero-prices');
        Route::patch('products/{product}/price', [\App\Http\Controllers\ProductPriceController::class, 'updateSinglePrice'])->name('products.update-price');
    });
});
