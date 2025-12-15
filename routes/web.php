<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthenticationController;

use App\Http\Controllers\_admin\AdminDashboardController;
use App\Http\Controllers\_admin\AdminUserController;

use App\Http\Controllers\_finance\FinanceDashboardController;
use App\Http\Controllers\_finance\FinanceTransactionController;
use App\Http\Controllers\_finance\FinanceTravelerController;
use App\Http\Controllers\_finance\FinanceConsignorController;
use App\Http\Controllers\_finance\FinanceRefundController;
use App\Http\Controllers\_finance\FinanceSettingController;

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

    // Traveler List
    Route::get('/travelers', [FinanceTravelerController::class, 'index'])->name('finance.travelers');
    
    // Consignor List
    Route::get('/consignor', [FinanceConsignorController::class, 'index'])->name('finance.consignor');
    
     // Transaction List
    Route::get('/transactions', [FinanceTransactionController::class, 'index'])->name('finance.transactions');

    // Refunds List
    Route::get('/refunds', [FinanceRefundController::class, 'index'])->name('finance.refunds');
    
    // Settings
    Route::get('/settings', [FinanceSettingController::class, 'index'])->name('finance.settings');
});

    

// --------------------------------------------------- SUPERADMIN -------------------------------------------------------
Route::middleware(['auth'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // Users List
    Route::get('/users', [SuperadminUserController::class, 'index'])->name('superadmin.users');

    // Products List
    Route::get('/products', [SuperadminProductController::class, 'index'])->name('superadmin.products');

    // Transactions List
    Route::get('/transactions', [SuperadminTransactionController::class, 'index'])->name('superadmin.transactions');

    // Transaction Details
    Route::get('/transaction/buy/{id}', [SuperadminTransactionController::class, 'showBuy'])->name('superadmin.transaction.buy.show');
    Route::get('/transaction/send/{id}', [SuperadminTransactionController::class, 'showSend'])->name('superadmin.transaction.send.show');
    Route::get('/transaction/{type}/{id}/edit', [SuperadminTransactionController::class, 'edit'])->name('superadmin.transaction.edit');

    // Refunds List
    Route::get('/refunds', [SuperadminRefundController::class, 'index'])->name('superadmin.refunds');

    // Settings
    Route::get('/settings', [SuperadminSettingController::class, 'index'])->name('superadmin.settings');
});