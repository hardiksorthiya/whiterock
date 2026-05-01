<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\CatalogueCategoryController;
use App\Http\Controllers\Backend\CatalogueController;
use App\Http\Controllers\Backend\ContactEnquiryController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\ProductApplicationController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductEnquiryController as BackendProductEnquiryController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProductEnquiryController as FrontendProductEnquiryController;
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
    Route::resource('catalogue-categories', CatalogueCategoryController::class);
    Route::resource('catalogues', CatalogueController::class);
    Route::resource('products', ProductController::class);
    Route::get('enquiery-entries', [BackendProductEnquiryController::class, 'index'])->name('enquiery-entries.index');
    Route::resource('applications', ProductApplicationController::class)->except(['show']);
    Route::get('contact-entries', [ContactEnquiryController::class, 'index'])->name('contact-entries.index');
    Route::resource('sliders', SliderController::class)->except(['show']);
    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('product-categories/bulk-action', [ProductCategoryController::class, 'bulkAction'])->name('product-categories.bulk-action');
    Route::post('catalogue-categories/bulk-action', [CatalogueCategoryController::class, 'bulkAction'])->name('catalogue-categories.bulk-action');
    Route::post('catalogues/bulk-action', [CatalogueController::class, 'bulkAction'])->name('catalogues.bulk-action');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::get('about', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('about', [AboutController::class, 'update'])->name('about.update');
});

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/products', [FrontendController::class, 'products'])->name('products');
Route::get('/categories/{slug}', [FrontendController::class, 'productCategory'])->name('product-category.show');
Route::get('/products/{slug}', [FrontendController::class, 'productShow'])->name('product.show');
Route::post('/product-enquiry', [FrontendProductEnquiryController::class, 'store'])->name('product-enquiry.store');
Route::post('/contact', [ContactUsController::class, 'store'])->name('contact.store');
Route::get('/pages/{slug}', [FrontendController::class, 'page'])->name('pages.show');
Route::get('google-reviews', [FrontendController::class, 'googleReviews'])->name('google-reviews');

require __DIR__.'/auth.php';
