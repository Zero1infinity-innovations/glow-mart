<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AssignProduct;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ShopLoginController extends Controller
{
    public function dashboard()
    {
        return view('admin.shop-login.dashboard');
    }

    public function productList()
    {
        $shopId = auth()->user()->shop_id;
        $assignedProducts = AssignProduct::where('shop_id', $shopId)->with(['product', 'variant'])->get()->groupBy('product_id');
        return view('admin.shop-login.productList', compact('assignedProducts'));
    }

    public function orderList()
    {
        $shopId = auth()->user()->shop_id;
        // dd(gettype($shopId));

        $orders = Order::where('shop_id', $shopId)->orderBy('created_at', 'desc')->paginate(10);

        foreach ($orders as $order) {
            $productIds = explode(',', $order->product_ids);
            $products = Product::whereIn('id', $productIds)->pluck('product_name')->toArray();
            $order->product_names = implode(', ', $products);
        }
        return view('admin.shop-login.orderList', compact('orders'));
    }

    public function orderCreate()
    {
        $shopId = auth()->user()->shop_id;

        $products = Product::where('quantity', '>', 0)->whereIn('id', function ($query) use ($shopId) {
            $query->select('product_id')->from('assign_products')->where('shop_id', $shopId);
        })->get();

        $users = User::where('shop_id', $shopId)->where('role_id', 2)->get();
        return view('admin.shop-login.orderCreate', compact('products', 'users'));
    }

    public function orderStore(Request $request)
    {
        $shopId = auth()->user()->shop_id;
        $userId = null;
        $username = '';

        // Check if user selected from dropdown or entered manually
        if ($request->user_id === 'Other') {
            $username = $request->input('otherName');
        } else {
            $user = \App\Models\User::find($request->user_id);
            if ($user) {
                $userId = $user->id;
                $username = $user->name;
            }
        }
        // Total Price Calculation
        $totalAmount = 0;
        foreach ($request->product_id as $key => $productId) {
            $price = $request->price[$key];
            $qty = is_array($request->qty) ? $request->qty[$key] : $request->qty;
            $totalAmount += $price * $qty;
        }
        
        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;

        $discountAmount = ($totalAmount * $discount) / 100;
        $taxAmount = ($totalAmount * $tax) / 100;
        $finalAmount = ($totalAmount - $discountAmount) + $taxAmount;

        // Generate Order Number (Random or custom logic)
        $orderNumber =  'ORD-' . strtoupper(Str::random(10));

        // Create Order
        $order = Order::create([
            'shop_id'       => $shopId,
            'user_id'       => $userId,
            'product_ids'   => implode(', ', $request->product_id),
            'username'      => $username,
            'order_number'  => $orderNumber,
            'total_amount'  => $totalAmount,
            'discount'      => $discountAmount,
            'tax_amount'    => $taxAmount,
            'final_amount'  => $finalAmount,
            'payment_method' => $request->payment_method ?? 'COD',
            'payment_status' => 'paid',
            'order_status'  => 'pending',
            'shipping_address' => NULL,
            'billing_address' => NULL,
            'notes' => NULL,
            'tracking_number' => null,
        ]);

        // Save Order Items and Product Stock
        foreach ($request->product_id as $key => $productId) {
            $sku = $request->sku[$key];
            $price = $request->price[$key];
            $qty = is_array($request->qty) ? $request->qty[$key] : $request->qty;
            // dd($sku);
            $product = Product::find($productId);

            // Save each product as an order item
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'sku'        => $sku,
                'quantity'   => $qty,
                'price'      => $price,
            ]);

            // Update product stock
            if ($product) {
                $product->quantity = max(0, $product->quantity - $qty);
                $product->save();
            }

            // Update inventory and stock movement
            try {
                $inventory = Inventory::where('product_id', $productId)->first();
                if ($inventory) {
                    $inventory->quantity = max(0, $inventory->quantity - $qty);
                    $inventory->save();

                    StockMovement::create([
                        'order_number' => $order->id,
                        'product_id'   => $productId,
                        'type'         => 'OUT',
                        'quantity'     => $qty,
                        'reason'       => 'Order #' . $order->order_number,
                    ]);
                } else {
                    Log::error("Inventory not found for product_id: " . $productId);
                }
            } catch (\Exception $e) {
                Log::error("Inventory update error: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.shop.order.list')->with('success', 'Order placed successfully and your final ammount id : ₹' . $finalAmount);
    }
}
