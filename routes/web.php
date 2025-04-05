<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Routes publiques
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Routes d'authentification
Auth::routes();

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    // Routes du panier
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout et commandes
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// Routes d'administration
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des catégories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Gestion des produits - chemin complet pour éviter les collisions
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    
    // Gestion des commandes - chemin complet pour éviter les collisions
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    // Génération de produits avec IA
    Route::get('/ai-products', [\App\Http\Controllers\Admin\AIProductController::class, 'index'])->name('ai-products.index');
    Route::post('/ai-products/generate', [\App\Http\Controllers\Admin\AIProductController::class, 'generate'])->name('ai-products.generate');
    Route::post('/ai-products/store', [\App\Http\Controllers\Admin\AIProductController::class, 'store'])->name('ai-products.store');
});