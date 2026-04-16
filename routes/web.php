<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

// Public front-end placeholder
Route::get('/', function () {
    return view('welcome');
});

// Admin authentication routes (guest only)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Admin panel routes (protected)
    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('posts', PostController::class);
        Route::resource('pages', PageController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('media', MediaController::class)->except(['create']);
    });
});
