<?php

use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// backend routes
Route::prefix('backend')->name('backend.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('sliders', SliderController::class)->except(['show']);
    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('product-categories/bulk-action', [ProductCategoryController::class, 'bulkAction'])->name('product-categories.bulk-action');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
});


Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/pages/{slug}', [FrontendController::class, 'page'])->name('pages.show');

require __DIR__.'/auth.php';
