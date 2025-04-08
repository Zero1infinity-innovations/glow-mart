<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Roles;
use App\Models\AssignProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::paginate(10);
        $products = Product::where('product_status', 1)->paginate(10);
        return view('admin.shops.index', compact('shops', 'products'));
    }

    public function createShop()
    {
        return view('admin.shops.create');
    }

    public function storeShopData(Request $request)
    {
       // Validation
       $request->validate([
            'shop_name'     => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'owner_email'   => 'required|email|unique:shops,owner_email',
            'city'          => 'required|string|max:255',
            'pincode'       => 'required|digits:6',
            'aadhar_number' => 'required|digits:12|unique:shops,aadhar_number',
            'pan_number'    => 'required|string|unique:shops,pan_number',
            'mobile_no'     => 'required|digits:10|unique:shops,phone_number',
            'password'      => 'required|string|min:8',
            'shop_status'   => ['required', Rule::in([0, 1])],
            'shop_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!file_exists(public_path('assets/shopIamges'))) {
            mkdir(public_path('assets/shopIamges'), 0777, true);
        }
       
        if($request->hasFile('shop_image')){
            $shopImage = $request->file('shop_image');
            $shopImageName = time() . '_' . $shopImage->getClientOriginalName();
            $shopImage->move(public_path('assets/shopIamges'), $shopImageName);
            $shopImagePath = 'assets/shopIamges/' . $shopImageName;
        }


        $shop = Shop::create([
            'shop_name'     => $request->shop_name,
            'owner_name'    => $request->owner_name,
            'owner_email'   => $request->owner_email,
            'city'          => $request->city,
            'address'       => $request->address,
            'pincode'       => $request->pincode,
            'aadhar_number' => $request->aadhar_number,
            'pan_number'    => $request->pan_number,
            'phone_number'  => $request->mobile_no,
            'shop_status'   => $request->shop_status,
            'shop_image'    => $shopImagePath ?? null,
        ]);

        $roles = Roles::where('guard_name', 'shop_user')->first();
        User::create([
            'role_id'  => $roles->id,
            'name'     => $request->owner_name,
            'email'    => $request->owner_email,
            'password' => Hash::make($request->password),
            'city'     => $request->city,
            'state'    => $request->state,
            'mobile'    => $request->mobile_no,
            'pincode'  => $request->pincode,
            'address'  => $request->address,
            'shop_id'  => $shop->id,
        ]);

        return redirect()->route('admin.shops.index')->with('success', 'Shop added successfully.');
    }

    public function editShop($id)
    {
        $shop = Shop::findOrFail($id);
        return view('admin.shops.edit', compact('shop'));
    }

    public function updateShop(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $request->validate([
            'shop_name'     => 'required|string|max:255',
            'owner_name'    => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'pincode'       => 'required|digits:6',
            'aadhar_number' => 'required|digits:12',
            'pan_number'    => 'required|string',
            'mobile_no'     => 'required|digits:10',
            'shop_status'   => ['required', Rule::in([0, 1])],
            'shop_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if($request->hasFile('shop_image')){
            $shopImage = $request->file('shop_image');
            $shopImageName = time() . '_' . $shopImage->getClientOriginalName();
            $shopImage->move(public_path('assets/shopIamges'), $shopImageName);
            $shopImagePath = 'assets/shopIamges/' . $shopImageName;

            $shop->shop_image       = $shopImagePath;
        }

        
        $shop->shop_name        = $request->shop_name;
        $shop->owner_name       = $request->owner_name;
        $shop->owner_email      = $request->owner_email;
        $shop->city             = $request->city;
        $shop->address          = $request->address;
        $shop->pincode          = $request->pincode;
        $shop->aadhar_number    = $request->aadhar_number;
        $shop->pan_number       = $request->pan_number;
        $shop->phone_number     = $request->mobile_no;
        $shop->shop_status      = $request->shop_status;
        $shop->update();
        

        return redirect()->route('admin.shops.index')->with('success', 'Shop updated successfully.');
    }

    public function destroy($id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully.');
    }

    public function getShopsByPincode($pincode)
    {
        $shops = Shop::where('pincode', $pincode)->get();

        if ($shops->isEmpty()) {
            return response()->json(['message' => 'No shops found'], 404);
        }

        return response()->json($shops);
    }

    public function assignProducts(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $product_ids = $request->input('product_ids', []);
        $quantities = $request->input('quantities', []);

        foreach ($product_ids as $product_id) {
            $quantity = $quantities[$product_id] ?? 1;

            AssignProduct::updateOrCreate(
                ['shop_id' => $shop_id, 'product_id' => $product_id],
                ['quantity' => $quantity]
            );
        }

        return response()->json(['success' => true]);
    }
}