<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function show(){
        $categories = Category::all();
        $user_id = Auth::id(); // Get currently logged in user id

        // Get cart items with product details
        $cartItems = Cart::with('product')
            ->where('user_id', $user_id)
            ->get();

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            // dd( $item->product->sale_price);
            $subtotal += $item->product->sale_price * $item->quantity;
        }
        // dd($subtotal);
        return view('pages.cart', compact('categories', 'cartItems', 'subtotal'));
    }

    public function add(Request $request){
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

        return response()->json(['success' => true]);
    }

    public function update(Request $request){
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = Cart::where('product_id', $productId)->first();

        if ($cart) {
            if ($quantity > 0) {
                $cart->quantity = $quantity;
                $cart->save();
            } else {
                $cart->delete(); // remove if quantity is 0
            }
        }

        return response()->json(['success' => true]);
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
                    ->select('products.sale_price', 'carts.quantity')
                    ->get();
    
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->sale_price * $item->quantity;
                });
    
                return response()->json([
                    'success' => true,
                    'deleted' => true,
                    'subtotal' => $subtotal
                ]);
            } else {
                // Update quantity
                DB::table('carts')->where('id', $cartId)->update(['quantity' => $newQuantity]);
    
                // Subtotal calculate
                $cartItems = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.user_id', $cart->user_id)
                    ->select('products.sale_price', 'carts.quantity')
                    ->get();
    
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->sale_price * $item->quantity;
                });
    
                return response()->json([
                    'success' => true,
                    'new_quantity' => $newQuantity,
                    'subtotal' => $subtotal
                ]);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

}
