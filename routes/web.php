<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdministrationController;

// Auth Routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch-role');

// Main App Routes (wrapped in MockAuthMiddleware automatically via Kernel)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard Group
Route::prefix('dashboard')->group(function () {
    Route::get('/executive', [DashboardController::class, 'executive'])->name('dashboard.executive');
    Route::get('/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
    Route::get('/area', [DashboardController::class, 'area'])->name('dashboard.area');
    Route::get('/early-warning', [DashboardController::class, 'earlyWarning'])->name('dashboard.early-warning');
});

// Master Group
Route::prefix('master')->group(function () {
    Route::get('/sales', [MasterController::class, 'sales'])->name('master.sales');
    Route::get('/sales/{npk}', [MasterController::class, 'salesDetail'])->name('master.sales.detail');
    Route::get('/outlet', [MasterController::class, 'outlet'])->name('master.outlet');
    Route::get('/outlet/{code}', [MasterController::class, 'outletDetail'])->name('master.outlet.detail');
    Route::get('/product', [MasterController::class, 'product'])->name('master.product');
    Route::get('/area', [MasterController::class, 'area'])->name('master.area');
    Route::get('/route', [MasterController::class, 'route'])->name('master.route');
    Route::get('/vehicle', [MasterController::class, 'vehicle'])->name('master.vehicle');
    Route::get('/market', [MasterController::class, 'market'])->name('master.market');
});

// Tracking Group
Route::prefix('tracking')->group(function () {
    Route::get('/live', [TransactionController::class, 'checkinGps'])->name('tracking.live');
});

// Transaksi Group
Route::prefix('transaksi')->group(function () {
    Route::get('/sales-visit', [TransactionController::class, 'salesVisit'])->name('transaksi.sales-visit');
    Route::get('/checkin-gps', [TransactionController::class, 'checkinGps'])->name('transaksi.checkin-gps');
    Route::get('/sales-order', [TransactionController::class, 'salesOrder'])->name('transaksi.sales-order');
    Route::get('/noo', [TransactionController::class, 'noo'])->name('transaksi.noo');
    Route::get('/nop', [TransactionController::class, 'nop'])->name('transaksi.nop');
    Route::get('/ro', [TransactionController::class, 'ro'])->name('transaksi.ro');
    Route::get('/ro-item', [TransactionController::class, 'roItem'])->name('transaksi.ro-item');
    Route::get('/account-proposal', [TransactionController::class, 'accountProposal'])->name('transaksi.account-proposal');
});

// Report Group
Route::get('/report', [ReportController::class, 'index'])->name('report.index');

// Administration Group
Route::prefix('administration')->group(function () {
    Route::get('/user', [AdministrationController::class, 'user'])->name('administration.user');
    Route::get('/role-permission', [AdministrationController::class, 'rolePermission'])->name('administration.role-permission');
    Route::get('/integration', [AdministrationController::class, 'integration'])->name('administration.integration');
    Route::get('/audit-log', [AdministrationController::class, 'auditLog'])->name('administration.audit-log');
});
