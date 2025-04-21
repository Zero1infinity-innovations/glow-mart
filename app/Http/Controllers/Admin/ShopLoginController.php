<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AssignProduct;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $productLists = AssignProduct::where('shop_id', $shopId)
                    ->with('product')
                    ->paginate(10);

        return view('admin.shop-login.productList', compact('productLists')); 
    }

    public function orderList(){
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

    public function orderCreate(){
        $shopId = auth()->user()->shop_id;

        $products = Product::where('quantity', '>', 0)->whereIn('id', function($query) use ($shopId) {
            $query->select('product_id')->from('assign_products')->where('shop_id', $shopId);
        })->get();
        
        $users = User::where('shop_id', $shopId)->where('role_id', 2)->get();
        return view('admin.shop-login.orderCreate', compact('products', 'users'));
    }
}
