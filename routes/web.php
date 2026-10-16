<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

// Dashboard sementara wat admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'title' => 'Dashboard Admin'
    ]);
})->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// Dashboard sementara wat user
Route::get('/user/dashboard', function () {
    return view('user.dashboard', [
        'title' => 'Dashboard User'
    ]);
})->middleware(['auth', 'role:user'])
    ->name('user.dashboard');