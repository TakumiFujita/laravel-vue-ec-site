<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // public function show()
    // {
    //     $product = Product::all();
    //     return response()->json($product);
    // }

    public function show($id)
    {
        $product = Product::find($id);
        // dd($product);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
