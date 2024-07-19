use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/cart', function () {
return view('cart');
});
