<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect homepage to blog
Route::get('/', function () {
    return redirect()->route('blog.index');
})->name('home');

// Blog routes (Public)
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('category');
    Route::get('/search', [App\Http\Controllers\BlogController::class, 'search'])->name('search');
    Route::get('/{post:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('show');
});

// Authentication routes
require __DIR__.'/auth.php';

// Admin routes (Admin Dashboard)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Blog Management
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::resource('posts', App\Http\Controllers\Admin\BlogAdminController::class);
        Route::resource('categories', App\Http\Controllers\Admin\CategoryAdminController::class);
    });
    
    // AdSense Management
    Route::resource('adsense', App\Http\Controllers\Admin\AdsenseAdminController::class);

});
