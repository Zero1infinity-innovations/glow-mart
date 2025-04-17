<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $categories  = Category::with(['subcategories' => function ($query) {
            $query->where('sub_menu_item', 1);
        }])->where('menu_item', 1)->orderBy('id', 'desc')->get();

        if(Auth::check() && Auth::user()->role_id == 2){
            $shopId = Auth::user()->shop_id;
            $products = DB::table('assign_products')->join('products', 'assign_products.product_id', '=', 'products.id')->where('assign_products.shop_id', $shopId)->select('products.*')->get();
        }else{
            $products = Product::orderBy('id', 'desc')->get();
        }

        // $subCategories  = SubCategory::where('sub_menu_item', 1)->get();
        $cartItems = [];
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->pluck('quantity', 'product_id')->toArray();
        }
        $count = Cart::where('user_id', $userId)->count();

        return view('pages.home', compact('products','categories', 'cartItems', 'count'));
    }

    public function ProductDetail($id){
        $userId = Auth::id();

        $categories  = Category::with(['subcategories' => function ($query) {
            $query->where('sub_menu_item', 1);
        }])->where('menu_item', 1)->orderBy('id', 'desc')->get();

        $products = Product::where('id', $id)->first();
        $gallery = 
        $isWishlisted = Wishlist::where('product_id', $id)->where('user_id', Auth::id())->first();

        $pageTitle = $products->product_name;
        $cartItems = [];
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->pluck('quantity', 'product_id')->toArray();
        }
        $count = Cart::where('user_id', $userId)->count();

        return view('pages.product-detail', compact('products','categories', 'cartItems', 'count', 'pageTitle', 'isWishlisted'));
    }
}
