<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TopupPackageController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// Dashboard sementara wat user
Route::get('/user/dashboard', function () {
    return view('user.dashboard', [
        'title' => 'Dashboard User'
    ]);
})->middleware(['auth', 'role:user'])
    ->name('user.dashboard');

Route::get('/games', [GameController::class, 'catalog'])
    ->middleware('auth')
    ->name('games.catalog');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('games', GameController::class);
        Route::resource('packages', TopupPackageController::class);
        Route::get('complaints', [AdminController::class, 'complaints'])
            ->name('complaints.index');
        Route::get('complaints/{complaint}', [AdminController::class, 'showComplaint'])
            ->name('complaints.show');
        Route::patch('complaints/{complaint}/status', [AdminController::class, 'updateComplaintStatus'])
            ->name('complaints.status');
    });

// Transaksi & Riwayat Pembelian
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    Route::post('/checkout', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/payment', [TransactionController::class, 'payment'])->name('transactions.payment');
    Route::post('/transactions/{transaction}/pay', [TransactionController::class, 'pay'])->name('transactions.pay');
    Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
});

