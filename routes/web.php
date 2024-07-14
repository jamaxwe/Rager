<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\NewsletterController;

// Authentication routes
// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::post('/verify-two-factor', [AuthManager::class, 'verifyTwoFactor'])->name('admin.verify');


// Admin routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('Admin.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('Admin.create');
    Route::post('/product', [ProductController::class, 'store'])->name('Admin.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('Admin.edit');
    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('Admin.update');
    Route::delete('/product/{product}/delete', [ProductController::class, 'delete'])->name('Admin.delete');
    
    Route::get('/admin/track-order', [OrderController::class, 'trackOrder'])->name('Admin.trackorder');
    Route::get('/admin/order-details/{id}', [OrderController::class, 'orderDetails'])->name('Admin.orderdetails');
    Route::post('/admin/track-order/{id}', [OrderController::class, 'updateStatus'])->name('Admin.updatestatus');
    Route::get('/saleschart', [OrderController::class, 'salesChart'])->name('Admin.chart');
    Route::get('/admin/logs', [ProductController::class, 'adminlogs'])->name('admin.logs');
    Route::patch('/admin/products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])->name('Admin.toggleAvailability');
});

// User-facing routes
Route::get('/shop', [ProductController::class, 'shop'])->name('user.shop');
Route::get('/shop/preview/{product}', [ProductController::class, 'preview'])->name('user.preview');
Route::get('/home', [ProductController::class, 'home'])->name('home');

// Cart routes
Route::match(['GET', 'POST'], '/shop/add-to-cart/{id}', [ProductController::class, 'addtocart'])->name('add_to_cart');
Route::get('/shop/cart', [ProductController::class, 'cart'])->name('user.cart');
Route::delete('/cart-delete/{key}', [ProductController::class, 'cartdelete'])->name('cart.delete');
Route::patch('/shop/cartupdate', [ProductController::class, 'cartupdate'])->name('cart.update');

// Order routes
Route::match(['GET', 'POST'], '/shop/checkout', [OrderController::class, 'checkout'])->name('user.checkout');
Route::post('/shop/checkout/placeorder', [OrderController::class, 'placeOrder'])->name('user.placeorder');
Route::get('/track-order', [OrderController::class, 'showTrackOrderForm'])->name('user.trackorderform');
Route::get('/track-order/search', [OrderController::class, 'usertrackOrder'])->name('user.trackordersearch');

// Rating routes
Route::post('/product/{product}/rate', [ProductController::class, 'rate'])->name('rate.product');

// Password reset routes
Route::get('password/reset', [AuthManager::class, 'forgotPasswordForm'])->name('password.request');
Route::post('password/email', [AuthManager::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthManager::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthManager::class, 'resetPassword'])->name('password.update');

// Catalog routes
Route::get('/catalogs', [CatalogController::class, 'showAll'])->name('catalogs.index');
Route::post('/catalogss', [CatalogController::class, 'store'])->name('catalogs.store');
Route::get('/catalogs/{id}', [CatalogController::class, 'show'])->name('catalogs.show');
Route::post('/catalogs/{id}/storeImages', [CatalogController::class, 'storeImages'])->name('catalogs.storeImages');
Route::get('/catalogs/{id}/carousel', [CatalogController::class, 'showCarouselForm'])->name('catalogs.showCarouselForm');
Route::post('/catalogs/{id}/storeCarouselImages', [CatalogController::class, 'storeCarouselImages'])->name('catalogs.storeCarouselImages');
Route::delete('/catalogs/deleteImage/{id}', [CatalogController::class, 'deleteImage'])->name('catalogs.deleteImage');
Route::delete('/catalogs/delete-image/{id}', [CatalogController::class, 'deleteImagecatalog'])->name('catalogs.deleteImagecatalog');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');