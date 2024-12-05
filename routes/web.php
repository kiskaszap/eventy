<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;

// Default Home Route
Route::get('/', function () {
    Log::info('Accessing Home Page.');
    return view('welcome');
});

// Events Page
Route::get('/events', function () {
    Log::info('Accessing Events Page.');
    $events = \App\Models\Event::all();
    return view('events-page', ['events' => $events]);
})->name('events');

// Single Event Page
Route::get('/event/{id}', [EventController::class, 'showSingleEvent'])->name('single-event-page');

// Login and Registration Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        Log::info('Accessing Email Verification Notice.', ['user_id' => Auth::id()]);
        return view('auth.verify-email'); // Add or customize this view
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        Log::info('Sending Email Verification Notification.', ['user_id' => $request->user()->id]);
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});
Route::delete('/delete-application/{event_id}/{user_id}', [UserController::class, 'deleteApplication'])->name('delete.application');

// Email Verification Handler
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    Log::info('Email verification requested.', [
        'user_id' => $id,
        'provided_hash' => $hash,
    ]);

    // Retrieve the user by ID
    $user = User::find($id);
    if (!$user) {
        Log::error('User not found for email verification.', ['user_id' => $id]);
        abort(404, 'User not found.');
    }

    // Verify the hash
    $expectedHash = sha1($user->getEmailForVerification());
    if (!hash_equals($expectedHash, $hash)) {
        Log::error('Invalid email verification link.', [
            'user_id' => $id,
            'expected_hash' => $expectedHash,
            'provided_hash' => $hash,
        ]);
        abort(403, 'Invalid verification link.');
    }

    // Check if the email is already verified
    if ($user->email_verified_at) {
        Log::info('Email already verified.', ['user_id' => $id]);
        return redirect()->route('login')->with('message', 'Your email is already verified.');
    }

    // Update the email_verified_at field
    $user->email_verified_at = Carbon::now();
    if ($user->save()) {
        Log::info('Email successfully verified.', ['user_id' => $id]);
    } else {
        Log::error('Failed to update email_verified_at field in database.', ['user_id' => $id]);
    }

    // Fire verified event
    event(new Verified($user));

    return redirect()->route('login')->with('message', 'Your email has been successfully verified. Please log in.');
})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

// Dashboard Routes for Authenticated and Verified Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/vendor-dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Event Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/create-event', [EventController::class, 'store'])->name('event.store');
    Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/book', [EventController::class, 'bookEvent'])->name('event.book');
    Route::post('/register-event/{id}', [EventController::class, 'registerEvent'])->name('register.event');
    Route::post('/cancel-booking', [EventController::class, 'cancelBooking'])->name('event.cancel');
    Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.delete');

});

// Comment Routes
Route::post('/events/{event_id}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


// Google Authentication Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Admin-Specific Routes
Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::post('/update-user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser']);
    Route::post('/set-active-component', [AdminController::class, 'setActiveComponent'])->name('setActiveComponent');
});

// Vendor-Specific Routes
Route::middleware(['auth', 'vendor', 'verified'])->group(function () {
    Route::post('/vendor/set-active-component', [VendorController::class, 'setActiveComponent'])->name('vendor.setActiveComponent');
    Route::delete('/events/{event_id}/users/{user_id}', [EventController::class, 'deleteApplication'])
    ->name('delete.application');



});

// Logout Route
Route::post('/logout', function () {
    Log::info('User Logged Out.', ['user_id' => Auth::id()]);
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
