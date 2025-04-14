<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {   
        if (Auth::check() && Auth::user()->role_id == 3) {
            $data = Inventory::with('product')->where('shop_id', Auth::user()->shop_id)->latest()->get();
        } else {
            $data = Inventory::with('product')->latest()->get();
        }
        return view('admin.inventries.index', compact('data'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventries.create', compact('products'));
    }

    public function getShopsByProduct(Request $request)
    {
        $productId = $request->product_id;

        // Step 1: Find all shop_ids where this product is assigned
        $shopIds = DB::table('assign_products')->where('product_id', $productId)->pluck('shop_id');

        // Step 2: Get shop details from shops table
        $shops = DB::table('shops')->whereIn('id', $shopIds)->select('id', 'shop_name')->get();

        return response()->json($shops);
    }
    public function storeInventory(Request $request)
    {

        $productId = $request->product_id;
        $quantity = $request->qty;
    
        // Check if shop_ids are passed
        if ($request->has('shop_ids') && !empty($request->shop_ids)) {
            $shopIds = $request->shop_ids; 

            foreach ($shopIds as $shopId) {
                $inventory = Inventory::where('product_id', $productId)->where('shop_id', $shopId)->first();
    
                if ($inventory) {
                    $inventory->quantity = $quantity;
                } else {
                    $inventory = new Inventory();
                    $inventory->product_id = $productId;
                    $inventory->shop_id = $shopId;
                    $inventory->quantity = $quantity;
                }
            }
        } else {
            $inventory = Inventory::where('product_id', $productId)->first();
    
            if ($inventory) {
                // If record found, update quantity
                $inventory->quantity = $quantity;
            } else {
                $inventory = new Inventory();
                $inventory->product_id = $productId;
                $inventory->shop_id = null;
                $inventory->quantity = $quantity;
            }
        }

        if ($inventory->save()) {
            return redirect()->route('admin.inventory.index')->with('success', 'Stock saved successfully');
        } else {
            return back()->with('error', 'Failed to save in inventory');
        }
    }

    public function stockMovements() {
        if (Auth::check() && Auth::user()->role_id == 3) {
            $data = DB::table('stock_movements')->leftJoin('orders', 'stock_movements.order_number', '=', 'orders.order_number')->leftJoin('products', 'stock_movements.product_id', '=', 'products.id')->where('orders.shop_id', Auth::user()->shop_id)->select('stock_movements.*', 'products.product_name')->get();
        }else{ 
            $data = DB::table('stock_movements')->leftJoin('orders', 'stock_movements.order_number', '=', 'orders.order_number')->leftJoin('products', 'stock_movements.product_id', '=', 'products.id')->select('stock_movements.*', 'products.product_name')->get();
        }
        return view('admin.inventries.stockMovementLog', compact('data'));
    }

    // public function lowStock(){
    //     if(Auth::check() && Auth::user()->role_id == 3){
    //         $data = DB::table('stock_movements')->leftJoin('orders', 'stock_movements.order_number', '=', 'orders.order_number')->leftJoin('products', 'stock_movements.product_id', '=', 'products.id')->leftJoin('inventories', 'stock_movements.product_id', '=', 'inventories.product_id')->where('orders.shop_id', Auth::user()->shop_id)->where('inventories.quantity', '<=', 5)->select('stock_movements.*', 'products.product_name', 'inventories.quantity as stock_quantity')->get();
    //     }else{
    //         $data = DB::table('stock_movements')->leftJoin('orders', 'stock_movements.order_number', '=', 'orders.order_number')->leftJoin('products', 'stock_movements.product_id', '=', 'products.id')->leftJoin('inventories', 'stock_movements.product_id', '=', 'inventories.product_id')->where('inventories.quantity', '<=', 5)->select('stock_movements.*', 'products.product_name', 'inventories.quantity as stock_quantity')->get();
    //     }
    //     dd($data);
    // }
}
