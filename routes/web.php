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
    
    Route::prefix('marketer')->name('marketer.')->group(function () {
        Route::resource('invoices', \App\Http\Controllers\Marketer\MarketerInvoiceController::class);
        Route::get('invoices/{id}/pdf', [\App\Http\Controllers\Marketer\MarketerInvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
        Route::get('stock', [\App\Http\Controllers\Marketer\StockController::class, 'index'])->name('stock.index');
        Route::get('earnings', [\App\Http\Controllers\Marketer\MarketerEarningsController::class, 'index'])->name('earnings.index');
    });
    
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        
        Route::get('stores', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('stores.index');
        
        Route::get('marketers', [\App\Http\Controllers\Admin\MarketerController::class, 'index'])->name('marketers.index');
        Route::get('marketers/{marketerId}/add-stock', [\App\Http\Controllers\Admin\MarketerController::class, 'addStockForm'])->name('marketers.add-stock');
        Route::post('marketers/{marketerId}/add-stock', [\App\Http\Controllers\Admin\MarketerController::class, 'addStock'])->name('marketers.add-stock.store');
        Route::get('marketers/{marketerId}/return-stock', [\App\Http\Controllers\Admin\MarketerController::class, 'returnStockForm'])->name('marketers.return-stock');
        Route::post('marketers/{marketerId}/return-stock', [\App\Http\Controllers\Admin\MarketerController::class, 'returnStock'])->name('marketers.return-stock.store');
        
        Route::get('store-debts', [\App\Http\Controllers\Admin\StoreDebtController::class, 'index'])->name('store-debts.index');
        Route::get('store-debts/{storeId}', [\App\Http\Controllers\Admin\StoreDebtController::class, 'show'])->name('store-debts.show');
        Route::post('store-debts/{storeId}/payments', [\App\Http\Controllers\Admin\StoreDebtController::class, 'storePayment'])->name('store-debts.payments.store');
        Route::put('store-debts/{storeId}/payments/{paymentId}', [\App\Http\Controllers\Admin\StoreDebtController::class, 'updatePayment'])->name('store-debts.payments.update');
    });
});
