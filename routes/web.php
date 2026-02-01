<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage shows blog directly
Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('home');

// Authentication routes (must be before catch-all routes)
require __DIR__.'/auth.php';

// TEST ROUTE - Title Image Generation Test
require __DIR__.'/test-image.php';

// Blog routes (Public)
Route::name('blog.')->group(function () {
    Route::get('/category/{category:slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('category');
    Route::get('/search', [App\Http\Controllers\BlogController::class, 'search'])->name('search');
});

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

// Blog show route (must be last as it's a catch-all)
Route::get('/{post:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
