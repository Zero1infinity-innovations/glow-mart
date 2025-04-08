<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AssignProduct;
use Illuminate\Support\Facades\Auth;

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
}
