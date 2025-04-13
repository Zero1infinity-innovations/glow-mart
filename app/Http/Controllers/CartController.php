<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function show()
    {
        $categories = Category::all();
        $user_id = Auth::id(); 
        // Get cart items with product details
        $cartItems = Cart::with('product')
            ->where('user_id', $user_id)
            ->get();

        // Calculate subtotal
        $subtotal = 0;
        $totalSavings = 0;

        foreach ($cartItems as $item) {
            $salePrice = $item->product->sale_price;
            $mrpPrice = $item->product->mrp_price;

            $subtotal += $salePrice * $item->quantity;

            // Calculate savings per item
            $savingPerItem = ($mrpPrice - $salePrice) * $item->quantity;
            $totalSavings += $savingPerItem;
        }
        $shopId = User::where('id', $user_id)->first();
        $count = Cart::where('user_id', $user_id)->count();
        // dd($subtotal);
        return view('pages.cart', compact('categories', 'cartItems', 'subtotal', 'totalSavings', 'count', 'shopId'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::id();

        $cart = Cart::where('product_id', $productId)->first();
        if ($cart) {
            $cart->quantity += 1;
        } else {
            $cart = new Cart([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
        $cart->save();
        $count = Cart::where('user_id', $userId)->count();

        return response()->json(['success' => true, 'cartCount' => $count]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = Cart::where('product_id', $productId)->first();

        if ($cart) {
            if ($quantity > 0) {
                $cart->quantity = $quantity;
                $cart->save();
            } else {
                $cart->delete();
            }
        }
        $count = Cart::where('user_id', $userId)->count();
        return response()->json(['success' => true, 'cartCount' => $count]);
    }

    // cart page
    public function updateQuantity(Request $request)
    {
        try {
            $cartId = $request->cart_id;
            $change = $request->change;

            $cart = DB::table('carts')->where('id', $cartId)->first();

            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Item not found']);
            }

            $newQuantity = $cart->quantity + $change;

            if ($newQuantity < 1) {
                // Quantity kam ho gaya, delete kar do item
                DB::table('carts')->where('id', $cartId)->delete();

                // Subtotal calculate karo user ke bache items ka
                $cartItems = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.user_id', $cart->user_id)
                    ->select('products.sale_price', 'products.mrp_price', 'carts.quantity')
                    ->get();

                    $itemCount = $cartItems->count();

                    $subtotal = 0;
                    $totalSavings = 0;
                    
                    foreach ($cartItems as $item) {
                        $subtotal += $item->sale_price * $item->quantity;
                    
                        $saving = ($item->mrp_price - $item->sale_price) * $item->quantity;
                        $totalSavings += $saving;
                    }

                return response()->json([
                    'success' => true,
                    'deleted' => true,
                    'subtotal' => $subtotal,
                    'total_savings' => $totalSavings,
                    'itemCount' => $itemCount,
                ]);
            } else {
                // Update quantity
                DB::table('carts')->where('id', $cartId)->update(['quantity' => $newQuantity]);

                // Subtotal calculate
                $cartItems = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.user_id', $cart->user_id)
                    ->select('products.sale_price', 'products.mrp_price', 'carts.quantity')
                    ->get();

                    $itemCount = $cartItems->count();
                    $subtotal = 0;
                    $totalSavings = 0;
                    
                    foreach ($cartItems as $item) {
                        $subtotal += $item->sale_price * $item->quantity;
                    
                        $saving = ($item->mrp_price - $item->sale_price) * $item->quantity;
                        $totalSavings += $saving;
                    }
                    

                return response()->json([
                    'success' => true,
                    'new_quantity' => $newQuantity,
                    'subtotal' => $subtotal,
                    'total_savings' => $totalSavings,
                    'itemCount' => $itemCount,

                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getShopAddress()
    {
        $userId = Auth::id();
        if ($userId) {
            $user = User::find($userId);
            $shopId = $user->shop_id;
            $shop = Shop::where('id', $shopId)->first();
            $fullAddress = $shop->address . ', ' . $shop->city . ' - ' . $shop->pincode;
            if ($shop) {
                return response()->json([
                    'success' => true,
                    'shopNo' => $shop->id,
                    'shopname' => $shop->shop_name,
                    'address' => $fullAddress, 
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No shop found for this User.',
                ]);
            }
        }
    }
}
