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
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, "index"])->name('home');
Route::get('/category', function () {
    return view('pages.category');
});
Route::get('/login', function () {
    return view('pages.login');
});
// Route::get('/cart', function () {
//     return view('pages.cart');
// });

Route::get('/cart', [CartController::class, 'show'])->name('cart');
Route::get('/get-address', [CartController::class, 'getShopAddress'])->name('getAddress');
// Add to cart (via AJAX)
Route::post('/add-cart', [CartController::class, 'add'])->name('add-cart');

// Update quantity (via AJAX)
Route::post('/update-cart', [CartController::class, 'update'])->name('update-cart');

// on cart page
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update-quantity');
// create order
Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('createOrder');

// payment
Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('paymentSuccess');

// after successfylly payment
Route::get('/order-placed', [PaymentController::class, 'orderPlaced'])->name('orderPlaced');



Route::get('/user', function () {
    return view('pages.user');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::match(['get','post'], 'login', [AuthController::class, 'login'])->name('login');

Route::get('/all-product', [AddproductController::class, 'allProduct'])->name('all-product');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/change-password', [ProfileController::class, 'changePasswordView'])->name('change-password');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Shop Module
Route::get('/get-shops/{pincode}', [ShopController::class, 'getShopsByPincode'])->name('getShop');
Route::get('/get-subcategories', [AddproductController::class, 'getSubcategories']);

