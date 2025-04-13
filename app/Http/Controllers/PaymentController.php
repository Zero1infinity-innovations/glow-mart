<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        // Get all cart items for the user
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty!']);
        }

        // Calculate subtotal and get product_ids
        $subtotal = 0;
        $productIds = [];

        foreach ($cartItems as $item) {
            $subtotal += $item->product->sale_price * $item->quantity;
            $productIds[] = $item->product_id;
        }

        $orderId =  'ORD-' . strtoupper(Str::random(10));
        // Create the order
        $order = new Order();
        $order->user_id = $userId;
        $order->shop_id = $request->shop_id;
        $order->product_ids = implode(',', $productIds);
        $order->order_number = $orderId;
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

        // Save items in order_items table
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->sale_price,
            ]);

            // Update product stock
            $product = $item->product;
            if ($product->quantity >= $item->quantity) {
                $product->quantity -= $item->quantity;
            } else {
                $product->quantity = 0;
            }
            $product->save();
            try {
                $inventory = Inventory::where('product_id', $item->product_id)->first();

                if (!$inventory) {
                    \Log::error('Inventory not found for product_id: ' . $item->product_id);
                } else {
                    $inventory->quantity -= $item->quantity;
                    $inventory->save();

                    StockMovement::create([
                        'product_id' => $item->product_id,
                        'type' => 'OUT',
                        'quantity' => $item->quantity,
                        'reason' => 'Order #' . $orderId
                    ]);
                }
            } catch (\Exception $e) {
                dd("Error: " . $e->getMessage());
            }
        }

        // Clear the user's cart
        Cart::where('user_id', $userId)->delete();

        return response()->json(['status' => 'success', 'message' => 'Order placed successfully.']);
    }


    public function orderPlaced()
    {
        $userId = Auth::id();
        $categories = Category::all();
        $count = Cart::where('user_id', $userId)->count();
        return view('pages.successfully', compact('categories', 'count'));
    }
}
