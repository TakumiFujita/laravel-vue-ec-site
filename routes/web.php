<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
