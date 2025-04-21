<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\inventories;
use App\Models\Inventory;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use const Adminer\DB;

class AddproductController extends Controller
{

    public function allProduct(Request $request)
    {
        $userId = Auth::id();
        $category_id = $request->query('category_id');
        $subcategory_id = $request->query('subcategory_id');
        if (Auth::check() && Auth::user()->role_id == 2) {
            $shop_id = Auth::user()->shop_id;

            $assignedProductIds = DB::table('assign_products')
                ->where('shop_id', $shop_id)
                ->pluck('product_id');

            if (!empty($subcategory_id)) {
                $products = Product::where('subCategory', $subcategory_id)
                    ->whereIn('id', $assignedProductIds)
                    ->get();
            } elseif (!empty($category_id)) {
                $products = Product::where('category', $category_id)
                    ->whereIn('id', $assignedProductIds)
                    ->get();
            } else {
                $products = Product::whereIn('id', $assignedProductIds)
                    ->orderBy('id', 'desc')
                    ->get();
            }
        } else {
            if (!empty($subcategory_id)) {
                $products = Product::where('subCategory', $subcategory_id)->get();
            } elseif (!empty($category_id)) {
                $products = Product::where('category', $category_id)->get();
            } else {
                $products = Product::orderBy('id', 'desc')->get();
            }
        }
        $categories = Category::all();
        $cartItems = [];
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->pluck('quantity', 'product_id')->toArray();
        }
        $count = Cart::where('user_id', $userId)->count();
        return view('pages.all-product', compact('products', 'categories', 'cartItems', 'count'));
    }

    public function index()
    {
        $categories = Category::all();
        $products = Product::with('categoryName')->orderBy('id', 'desc')->get();
        return view('admin.product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'product_name'      => 'required|string|max:255',
        //     'sale_price'        => 'required',
        //     'mrp_price'         => 'required',
        //     'quantity'          => 'required',
        //     'product_image'     => 'image|mimes:jpeg,png,jpg|max:2048',
        //     'product_gallery'   => 'image|mimes:jpeg,png,jpg|max:2048',
        //     'category'          => 'required',
        //     'product_status'    => 'required',
        //     'payment_method'    => 'required',
        //     'description'       => 'nullable',
        // ]);

        // Ensure the directories exist
        if (!file_exists(public_path('assets/products'))) {
            mkdir(public_path('assets/products'), 0777, true);
        }
        if (!file_exists(public_path('assets/products/gallery'))) {
            mkdir(public_path('assets/products/gallery'), 0777, true);
        }

        // Handle main product image
        $productImage = $request->file('product_image');
        $productImageName = time() . '_' . $productImage->getClientOriginalName();
        $productImage->move(public_path('assets/products'), $productImageName);
        $productImagePath = 'assets/products/' . $productImageName;

        // Handle gallery images
        $galleryImages = [];
        if ($request->hasFile('product_gallery')) {
            foreach ($request->file('product_gallery') as $image) {
                $galleryImageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/products/gallery'), $galleryImageName);
                $galleryImages[] = 'assets/products/gallery/' . $galleryImageName;
            }
        }

        // Save product data
        $product = new Product();
        $product->product_name          = $request->product_name;
        $product->sale_price            = $request->sale_price;
        $product->mrp_price             = $request->mrp_price;
        $product->quantity              = $request->quantity;
        $product->product_image         = $productImagePath;
        $product->product_gallery       = json_encode($galleryImages);
        $product->category              = $request->category;
        $product->subcategory           = $request->subcategory;
        $product->product_status        = $request->product_status;
        $product->payment_method        = $request->payment_method;
        $product->description           = $request->description;

        if ($product->save()) {
            Inventory::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
            return redirect()->route('admin.product.index')->with('success', 'Product added successfully');
        } else {
            return back()->with('error', 'Failed to save product');
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $subCategory = SubCategory::all();
        $selectedCategoryId = $product->category;
        $selectedSubcategoryId = $product->subcategory;
        return view('admin.product.edit', compact('product', 'categories', 'subCategory',  'selectedCategoryId', 'selectedSubcategoryId'));
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'product_name'      => 'required|string|max:255',
        //     'sale_price'        => 'required|numeric',
        //     'mrp_price'         => 'required|numeric',
        //     'quantity'          => 'required|integer',
        //     'category'          => 'required|integer',
        //     'product_status'    => 'required|string',
        //     'payment_method'    => 'required|string',
        //     'description'       => 'nullable|string',
        // ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $productImageName = time() . '_' . $productImage->getClientOriginalName();
            $productImage->move(public_path('assets/products'), $productImageName);
            $product->product_image = 'assets/products/' . $productImageName;
        }

        $galleryImages = json_decode($product->product_gallery, true) ?? [];
        if ($request->hasFile('product_gallery')) {
            foreach ($request->file('product_gallery') as $image) {
                $galleryImageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/products/gallery'), $galleryImageName);
                $galleryImages[] = 'assets/products/gallery/' . $galleryImageName;
            }
            $product->product_gallery = json_encode($galleryImages);
        }

        $product->product_name      = $request->product_name;
        $product->sale_price        = $request->sale_price;
        $product->mrp_price         = $request->mrp_price;
        $product->quantity          = $request->quantity;
        $product->category          = $request->category;
        $product->subcategory       = $request->subcategory;
        $product->product_status    = $request->product_status;
        $product->payment_method    = $request->payment_method;
        $product->description       = $request->description;

        if ($product->save()) {
            Inventory::create([
                'product_id' => $id,
                'quantity' => $request->quantity
            ]);
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
        } else {
            return back()->with('error', 'Failed to update product');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = SubCategory::where('parent_cate_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    public function storeProductVariance(Request $request)
    {

        try {
            // Generate SKU from product name + variant
            $prefix = strtoupper($request->product_name);
            $sku = $prefix . '-' . strtoupper(str_replace(' ', '', $request->variant));

            // Image upload logic
            $imageNames = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/variants/'), $imageName);
                    $imageNames[] = $imageName;
                }
            }
            // Save to DB
            ProductVariant::create([
                'product_id'    => $request->productSelect,
                'variant_name'  => $request->variant_name,
                'size'          => $request->variant,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'sku'           => $sku,
                'image'         => implode(',', $imageNames),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Variant saved successfully!',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
