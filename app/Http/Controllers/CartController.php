<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $userId = Auth::id();

            // ユーザーのカート内の商品を取得
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

            // カート内の商品を JSON で返す
            return response()->json($cartItems);
        }

        return response()->json(['status' => 'error', 'message' => 'User not logged in'], 401);
    }


    public function addToCart($id)
    {
        Log::info('addToCart method called with id: ' . $id);
        // dd($id);
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
            // Log::info('Cart Item: ' . print_r($cartItem, true));
            Log::info('in auth check');

            // $cartItems = $this->getCartItems($userId);

            // return response()->json(['status' => 'success', 'cartItems' => $cartItems]);
            return redirect()->route('cart.index');
        }

        Log::info('before return');
        return response()->json(['status' => 'error', 'message' => 'User not logged in'], 401);
    }

    public function destroy($id)
    {
        Log::info("Deleting item with ID: {$id}");
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }

    public function getCartItemCount()
    {
        $userId = auth()->id();
        if ($userId) {
            $cartCount = Cart::where('user_id', $userId)->count();
            return response()->json(['count' => $cartCount]);
        }
        return response()->json(['count' => 0]);
    }

    public function clearCart()
    {
        $userId = auth()->id();
        if (!$userId) {
            Log::error('User not authenticated');
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        try {
            Cart::where('user_id', $userId)->delete();
            Log::info('Cart cleared for user ID: ' . $userId);
            return response()->json(['message' => 'Cart cleared successfully.']);
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to clear cart'], 500);
        }
    }
}
