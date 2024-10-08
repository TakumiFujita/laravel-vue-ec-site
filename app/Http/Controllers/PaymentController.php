<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('VITE_STRIPE_SECRET_KEY'));

        // カート内の商品を取得
        $carts = $request->user()->carts;

        // Stripeに渡すline_itemsを作成
        $lineItems = [];
        foreach ($carts as $cart) {
            $product = $cart->product;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'JPY',
                    'product_data' => [
                        'name' => $product->name, // 各商品の名前を設定
                    ],
                    'unit_amount' =>  (int)($product->price),
                ],
                'quantity' => $cart->quantity, // 商品の数量を設定
            ];
        }

        try {
            // StripeのCheckoutセッションを作成
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => env('APP_URL') . '/payment-success', // 成功時のリダイレクトURL
                'cancel_url' => env('APP_URL') . '/payment-cancel',   // キャンセル時のリダイレクトURL
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            Log::error('Stripe Checkout Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create Stripe session'], 500);
        }
    }
}
