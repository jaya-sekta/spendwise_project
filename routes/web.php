<?php
// routes/web.php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserRewardController;
use App\Http\Controllers\Admin\RewardController as AdminRewardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
// routes/web.php
use App\Http\Controllers\DashboardController;

// Pastikan diletakkan di dalam blok middleware('auth')
Route::middleware('auth')->group(function () {
    
    // Jadikan dashboard sebagai halaman utama setelah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ... route expenses, categories, dll yang sebelumnya
});

Auth::routes();

// Route untuk semua user yang sudah login
Route::middleware('auth')->group(function () {

    // Redirect home setelah login (handle berdasarkan role di HomeController)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Expenses
    Route::resource('expense', ExpenseController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Challenges
    Route::resource('challenges', ChallengeController::class);

    // Rewards (lihat & redeem)
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/{reward}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');

    // User Rewards (riwayat penukaran)
    Route::get('/user-rewards', [UserRewardController::class, 'index'])->name('user-rewards.index');

    // Route khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('rewards', AdminRewardController::class);
        Route::resource('users', AdminUserController::class);
    });

});