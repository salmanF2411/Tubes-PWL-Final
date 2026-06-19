<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES - LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// PROTECTED ROUTES - REQUIRE AUTHENTICATION
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('can:view dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Notifications
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::patch('/notifikasi/baca-semua', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::get('/notifikasi/{notification}/buka', [NotificationController::class, 'open'])->name('notifikasi.open');
    Route::patch('/notifikasi/{notification}/baca', [NotificationController::class, 'markAsRead'])->name('notifikasi.read');

    // Products
    Route::get('/produk', [ProductController::class, 'index'])
        ->name('produk')
        ->middleware('can:view products');
    Route::post('/produk', [ProductController::class, 'store'])
        ->name('produk.store')
        ->middleware('can:create product');
    Route::put('/produk/{product}', [ProductController::class, 'update'])
        ->name('produk.update')
        ->middleware('can:edit product');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])
        ->name('produk.destroy')
        ->middleware('can:delete product');

    // Stock/Inventory
    Route::get('/stok', [StockController::class, 'index'])
        ->name('stok')
        ->middleware('can:view inventory');
    Route::post('/stok/transfer', [StockController::class, 'storeTransfer'])
        ->name('stok.transfer.store')
        ->middleware('can:manage stock');
    Route::post('/stok/transfer/{stockTransfer}/confirm', [StockController::class, 'confirmTransfer'])
        ->name('stok.transfer.confirm')
        ->middleware('can:manage stock');

    // Transactions
    Route::get('/transaksi', [TransactionController::class, 'index'])
        ->name('transaksi')
        ->middleware('can:view transactions');
    Route::post('/transaksi', [TransactionController::class, 'store'])
        ->name('transaksi.store')
        ->middleware('can:create transaction');

    // Stock Reports
    Route::get('/laporan-stok', [ReportController::class, 'stocks'])
        ->name('laporan-stok')
        ->middleware('can:view reports');
    Route::get('/laporan-stok/pdf', [ReportController::class, 'stocksPdf'])
        ->name('laporan-stok.pdf')
        ->middleware('can:export reports');
    Route::get('/laporan-stok/excel', [ReportController::class, 'stocksExcel'])
        ->name('laporan-stok.excel')
        ->middleware('can:export reports');

    // Transaction Reports
    Route::get('/laporan-transaksi', [ReportController::class, 'transactions'])
        ->name('laporan-transaksi')
        ->middleware('can:view reports');
    Route::get('/laporan-transaksi/pdf', [ReportController::class, 'transactionsPdf'])
        ->name('laporan-transaksi.pdf')
        ->middleware('can:export reports');
    Route::get('/laporan-transaksi/excel', [ReportController::class, 'transactionsExcel'])
        ->name('laporan-transaksi.excel')
        ->middleware('can:export reports');

    // User Management - Only for Owner and Store Manager
    Route::get('/kelola-user', [UserManagementController::class, 'index'])
        ->name('kelola-user')
        ->middleware('can:view users');
    Route::post('/kelola-user', [UserManagementController::class, 'store'])
        ->name('kelola-user.store')
        ->middleware('can:create user');
    Route::put('/kelola-user/{user}', [UserManagementController::class, 'update'])
        ->name('kelola-user.update')
        ->middleware('can:edit user');
    Route::delete('/kelola-user/{user}', [UserManagementController::class, 'destroy'])
        ->name('kelola-user.destroy')
        ->middleware('can:delete user');
});
