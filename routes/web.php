<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', function () {
    return view('register');
})->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Vendor Routes
Route::middleware(['auth', 'vendor'])->group(function () {
    Route::get('/vendor-dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
});

// User Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});


Route::get('/admin-dashboard/users', function () {
    return view('user-list'); // Render the user list view
})->name('admin.users');