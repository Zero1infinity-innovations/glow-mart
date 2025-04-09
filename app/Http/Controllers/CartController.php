<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function show(){
        return view('pages.cart');
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
}
