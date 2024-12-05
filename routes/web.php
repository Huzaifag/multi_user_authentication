<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

# Routes for users
Route::prefix('account')->group(function () {

    # Guest Middleware for account login
    Route::group(['middleware'=> "guest"],function(){
        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });

    # Auth Middleware for account dashboard
    Route::group(['middleware'=> "auth"],function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
    });
});



# Routes for admin
Route::prefix('admin')->group(function () {

    # Guest Middleware for admin login
    Route::group(['middleware'=> "admin.guest"],function(){
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    # Auth Middleware for admin dashboard
    Route::group(['middleware'=> "admin.auth"],function(){
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});





