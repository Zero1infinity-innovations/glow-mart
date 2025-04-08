<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Admin\AddproductController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ShopController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    $products = Product::orderBy('id', 'desc')->get();
    $categories  = Category::with(['subcategories' => function ($query) {
        $query->where('sub_menu_item', 1);
    }])->where('menu_item', 1)->orderBy('id', 'desc')->get();

    // $subCategories  = SubCategory::where('sub_menu_item', 1)->get();
    return view('pages.home', compact('products','categories'));
});
Route::get('/category', function () {
    return view('pages.category');
});
Route::get('/login', function () {
    return view('pages.login');
});
Route::get('/cart', function () {
    return view('pages.cart');
});
Route::get('/user', function () {
    return view('pages.user');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('/all-product', [AddproductController::class, 'allProduct'])->name('all-product');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/change-password', [ProfileController::class, 'changePasswordView'])->name('change-password');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Shop Module
Route::get('/get-shops/{pincode}', [ShopController::class, 'getShopsByPincode']);
Route::get('/get-subcategories', [AddproductController::class, 'getSubcategories']);

