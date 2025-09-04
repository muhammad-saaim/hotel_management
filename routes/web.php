<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\BookingController; // Admin Bookings
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\UserController;

// -----------------
// Homepage
// -----------------
Route::get('/', function () {
    return view('welcome');
});

// -----------------
// Admin Routes
// -----------------
Route::prefix('admin')->group(function () {

    // Guest-only admin routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    });

    // Authenticated admin routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        // ----------------- Dashboard Stats for AJAX -----------------
        Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('admin.dashboard.stats');

        // ----------------- Admin Features -----------------
        Route::get('/features', [FeatureController::class, 'index'])->name('admin.features.index');
        Route::get('/features/reports', [FeatureController::class, 'reports'])->name('admin.features.reports');

        // ----------------- Admin Rooms -----------------
        Route::prefix('rooms')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('admin.rooms.index');
            Route::get('/create', [RoomController::class, 'create'])->name('admin.rooms.create');
            Route::post('/store', [RoomController::class, 'store'])->name('admin.rooms.store');
            Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('admin.rooms.edit');
            Route::put('/update/{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
            Route::delete('/delete/{room}', [RoomController::class, 'destroy'])->name('admin.rooms.delete');
        });

        // ----------------- Admin Bookings -----------------
        Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');
        Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('admin.bookings.cancel');

        // ----------------- Admin Users -----------------
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::get('/users/edit/{user}', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/update/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/delete/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});

// -----------------
// User Routes
// -----------------
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // Rooms & Bookings
    Route::get('/rooms', [UserController::class, 'rooms'])->name('user.rooms');
    Route::post('/rooms/book/{roomId}', [UserController::class, 'bookRoom'])->name('user.rooms.book');

    Route::get('/bookings', [UserController::class, 'bookings'])->name('user.bookings');
    Route::delete('/bookings/{id}/cancel', [UserController::class, 'cancelBooking'])->name('user.bookings.cancel');
});
