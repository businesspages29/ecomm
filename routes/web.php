<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->controller(ProductController::class)->group(function () {
    Route::get('products/{slug}', 'show')->name('products.show');
    Route::get('cart', 'cart')->name('cart');
    Route::get('add-to-cart/{id}', 'addToCart')->name('cart.add');
    Route::patch('update-cart', 'update')->name('update.cart');
    Route::delete('remove-from-cart', 'remove')->name('remove.from.cart');
    Route::post('checkout', 'checkout')->name('checkout');
    Route::get('orders', 'orders')->name('orders');
});
