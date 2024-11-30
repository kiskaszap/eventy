<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/events', [EventController::class, 'showProducts'])->name('products');

Route::get('/events', function () {
    $events = \App\Models\Event::all(); // Fetch all events
    return view('events', ['events' => $events]); // Pass events to the view
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

Route::post('/set-active-component', [AdminController::class, 'setActiveComponent'])->name('setActiveComponent');


// Event Routes
Route::middleware(['auth'])->group(function () {

    Route::post('/create-event', [EventController::class, 'store'])->name('event.store');
});

Route::post('/event/book', [EventController::class, 'bookEvent'])->name('event.book');

Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');



Route::post('/register-event/{id}', [EventController::class, 'registerEvent'])->name('register.event');

Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::post('/update-user/{id}', [AdminController::class, 'updateUser']);

Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser']);

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/'); // Visszatérés a főoldalra
})->name('logout');
