<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthenticationController;

use App\Http\Controllers\_admin\AdminDashboardController;
use App\Http\Controllers\_admin\AdminUserController;

use App\Http\Controllers\_finance\FinanceDashboardController;

use App\Http\Controllers\_superadmin\SuperadminDashboardController;
use App\Http\Controllers\_superadmin\SuperadminUserController;
use App\Http\Controllers\_superadmin\SuperadminProductController;
use App\Http\Controllers\_superadmin\SuperadminTransactionController;
use App\Http\Controllers\_superadmin\SuperadminRefundController;
use App\Http\Controllers\_superadmin\SuperadminSettingController;

// ------------------- AUTHENTICATION -------------------
Route::get('/login', [AuthenticationController::class, 'signIn'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('/register', [AuthenticationController::class, 'signUp']);
Route::get('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('password.request');

// ===========================space for landing page============================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'finance' => redirect('/finance/dashboard'),
            'superadmin' => redirect('/superadmin/dashboard'),
            default => view('dashboard'),
        };
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --------------------------------------------------- ADMIN -------------------------------------------------------
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
});

// --------------------------------------------------- FINANCE -------------------------------------------------------
Route::middleware(['auth'])->prefix('finance')->group(function () {
    Route::get('/dashboard', [FinanceDashboardController::class, 'index'])->name('finance.dashboard');
});

// --------------------------------------------------- SUPERADMIN -------------------------------------------------------
Route::middleware(['auth',])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // Users List
    Route::get('/users', [SuperadminUserController::class, 'index'])->name('superadmin.users');

    // Products List
    Route::get('/products', [SuperadminProductController::class, 'index'])->name('superadmin.products');
    Route::get('/products/export', [SuperadminProductController::class, 'export'])->name('superadmin.products.export');
    Route::get('/products/{id}', [SuperadminProductController::class, 'show'])->name('superadmin.products.show');
    Route::post('/products/{id}/approve', [SuperadminProductController::class, 'approve'])->name('superadmin.products.approve');
    Route::post('/products/{id}/reject', [SuperadminProductController::class, 'reject'])->name('superadmin.products.reject');

    // Transactions List
    Route::get('/transactions', [SuperadminTransactionController::class, 'index'])->name('superadmin.transactions');
    Route::get('/transactions/export', [SuperadminTransactionController::class, 'export'])->name('superadmin.transactions.export');

    // Transaction Details
    Route::get('/transactions/{id}', [SuperadminTransactionController::class, 'show'])->name('superadmin.transactions.show');
    Route::delete('/transactions/{id}', [SuperadminTransactionController::class, 'destroy'])->name('superadmin.transactions.destroy');

    // Refunds List
    Route::get('/refunds', [SuperadminRefundController::class, 'index'])->name('superadmin.refunds');

    // Settings
    Route::get('/settings', [SuperadminSettingController::class, 'index'])->name('superadmin.settings');
});