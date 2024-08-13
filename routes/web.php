<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

require __DIR__ . '/auth.php';

Route::get('/products', [ProductController::class, 'index']);
Route::get('/productDetail/{id}', [ProductController::class, 'show']);
Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');

Route::get('/', function () {
    return view('welcome');
});
