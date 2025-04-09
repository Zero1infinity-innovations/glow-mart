<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayOrder = $api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $request->amount,
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $razorpayOrder->id,
            'amount' => $request->amount,
            'key' => env('RAZORPAY_KEY')
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        // Sabhi product IDs nikal lo
        $productIds = $cartItems->pluck('product_id')->toArray();

        // Comma-separated string banao
        $productIdsString = implode(',', $productIds);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->sale_price * $item->quantity;
        }

        $order = new order();
        $order->user_id = $userId;
        $order->product_ids = $productIdsString;
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->total_amount = $subtotal;
        $order->discount = 0;
        $order->tax_amount = 0;
        $order->shipping_charge = 0;
        $order->final_amount = $subtotal;
        $order->payment_method = 'Razorpay';
        $order->payment_status = 'paid';
        $order->order_status = 'processing';
        $order->transaction_id = $request->razorpay_payment_id;
        $order->payment_time = now();
        $order->shipping_address = 'Default Address';
        $order->billing_address = 'Default Billing';
        $order->notes = null;
        $order->tracking_number = null;
        $order->save();

        // Update product quantity
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->quantity >= $item->quantity) {
                $product->quantity -= $item->quantity;
            } else {
                $product->quantity = 0; // Avoid negative stock
            }
            $product->save();
        }

        // Clear user cart
        Cart::where('user_id', $userId)->delete();

        return response()->json(['status' => 'success']);
    }

    public function orderPlaced(){
        $categories = Category::all();
        return view('pages.successfully', compact('categories'));
    }
}
