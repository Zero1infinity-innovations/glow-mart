<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $products = Product::orderBy('id', 'desc')->get();
        $categories  = Category::with(['subcategories' => function ($query) {
            $query->where('sub_menu_item', 1);
        }])->where('menu_item', 1)->orderBy('id', 'desc')->get();

        // $subCategories  = SubCategory::where('sub_menu_item', 1)->get();
        $cartItems = [];
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->pluck('quantity', 'product_id')->toArray();
        }

        return view('pages.home', compact('products','categories', 'cartItems'));
    }
}
