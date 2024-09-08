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


    public function addToCart(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);


        // ユーザーがログインしているか確認
        if (Auth::check()) {
            $userId = Auth::id();

            // カートアイテムをデータベースで検索
            $cartItem = Cart::where('user_id', $userId)->where('product_id', $id)->first();

            if ($cartItem) {
                // 既存のカートアイテムが存在する場合、数量を追加
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // カートアイテムが存在しない場合、新規作成
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $id,
                    'quantity' => $quantity,
                ]);
            }
            return redirect()->route('cart.index');
        }

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
            // distinct を使って、user_id でグループ化し、product_id をユニークにカウント
            $uniqueItemCount = Cart::where('user_id', $userId)
                ->distinct('product_id')
                ->count('product_id');
            Log::info("$uniqueItemCount, {$uniqueItemCount}");
            return response()->json(['count' => $uniqueItemCount]);
        }
        return response()->json(['count' => 0]);
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // カート内の数量を更新
        $cartItem = Cart::where('id', $id)->first();
        if ($cartItem) {
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Item not found'], 404);
        }
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
