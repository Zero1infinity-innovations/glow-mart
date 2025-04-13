<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Inventory::with('product')->latest()->get();
        return view('admin.inventries.index', compact('data'));
    }

    public function create(){
        $products = Product::all();
        return view('admin.inventries.create', compact('products'));
    }

    public function storeInventory(Request $request){

        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if ($inventory) {
            // Agar record mil gaya to quantity update karo
            $inventory->quantity = $request->qty;
        } else {
            // Record nahi mila, naya record banao
            $inventory = new Inventory();
            $inventory->product_id = $request->product_id;
            $inventory->quantity = $request->qty;
        }

        if ($inventory->save()) {
            return redirect()->route('admin.inventory.index')->with('success', 'Stock saved successfully');
        } else {
            return back()->with('error', 'Failed to save in inventory');
        }
    }

    public function stockMovements(){
        
    }
}
