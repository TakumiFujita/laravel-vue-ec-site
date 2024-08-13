<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart($id)
    {
        Log::info('addToCart method called with id: ' . $id);
        dd($id);
        // $productId = $request->input('product_id');
        $quantity = 1;

        // ユーザーがログインしているか確認
        if (Auth::check()) {
            $userId = Auth::id();

            // カートアイテムをデータベースに保存
            $cartItem = Cart::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $id],
                ['quantity' => $quantity]
            );

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'User not logged in'], 401);
    }
}
