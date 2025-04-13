<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddproductController;
use App\Http\Controllers\Admin\ShopLoginController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;

// Before Login Route Start
Route::namespace('Auth')->controller(AuthController::class)->middleware(['guest'])->group(function(){
    Route::get('/','login')->name('login');
    Route::post('/do-login','doLogin')->name('do.login');
});

Route::middleware(['auth'])->group(function() {
    Route::controller(DashBoardController::class)->group(function(){
        Route::get('dashboard','dashboard')->name('dashboard');
        Route::get('logout','logOut')->name('logout');
    });

    Route::controller(BannerController::class)->prefix('banner')->name('banner.')->group(function(){
        Route::get('/','index')->name('index');
        Route::get('create','create')->name('create');
        Route::post('store','store')->name('store');
        Route::post('/changes-status','changeStatus')->name('change.status');
        Route::get('/edit/{id}','edit')->name('edit');
        Route::post('/update','update')->name('update');
    });

    Route::controller(EmailSettingController::class)->prefix('email-settings')->name('email.settings.')->group(function(){
        Route::get('/','index')->name('index');
        Route::post('store','store')->name('store');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [AddproductController::class, 'index'])->name('product.index');
        Route::get('create', [AddproductController::class, 'create'])->name('product.create');
        Route::post('store', [AddproductController::class, 'store'])->name('product.store');
        Route::get('edit/{id}', [AddproductController::class, 'edit'])->name('product.edit');
        Route::post('update/{id}', [AddproductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}', [AddproductController::class, 'destroy'])->name('product.destroy');
    });

    Route::prefix('shops')->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('shops.index');
        Route::get('shop-create', [ShopController::class, 'createShop'])->name('shops.create');
        Route::post('shop-store-data', [ShopController::class, 'storeShopData'])->name('shops.store');
        Route::get('shop-edit/{id}', [ShopController::class, 'editShop'])->name('shops.edit');
        Route::post('shop-update/{id}', [ShopController::class, 'updateShop'])->name('shops.update');
        Route::delete('shop/{id}', [ShopController::class, 'destroyShop'])->name('shops.destroy');

        Route::post('assign-products', [ShopController::class, 'assignProducts'])->name('shops.assign');
    });

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('category-create', [CategoryController::class, 'categoryAdd'])->name('category.create');
        Route::post('category-store-data', [CategoryController::class, 'categoryData'])->name('category.store');
        Route::get('category-edit/{id}', [CategoryController::class, 'editCategory'])->name('category.edit');
        Route::post('category-update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
        Route::delete('category/{id}', [CategoryController::class, 'destroyCategory'])->name('category.destroy'); 
    });

    Route::prefix('sub-category')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('sub-category.index');
        Route::get('sub-category-create', [SubCategoryController::class, 'subcategoryAdd'])->name('sub-category.create');
        Route::post('sub-category-store-data', [SubCategoryController::class, 'subCategoryData'])->name('sub-category.store');
        Route::get('sub-category-edit/{id}', [SubCategoryController::class, 'editSubCategory'])->name('sub-category.edit');
        Route::post('sub-category-update/{id}', [SubCategoryController::class, 'updateSubCategory'])->name('sub-category.update');
        Route::delete('sub-category/{id}', [SubCategoryController::class, 'destroySubCategory'])->name('sub-category.destroy');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('show-order/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::post('order/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
        Route::get('order/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');
    });

    // inventory
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('/store', [InventoryController::class, 'storeInventory'])->name('inventory.store');
        Route::get('/movements', [InventoryController::class, 'stockMovements'])->name('inventory.movements');
        Route::get('/lowstock', [InventoryController::class, 'lowStock'])->name('inventory.lowstock');
        Route::get('/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    });

    // shop login
    Route::prefix('shop')->group(function () {
        Route::get('/', [ShopLoginController::class, 'dashboard'])->name('shop.dashboard');
        Route::get('product-list', [ShopLoginController::class, 'productList'])->name('shop.product.list');
        Route::get('order-list', [ShopLoginController::class, 'orderList'])->name('shop.order.list');
    });
    
    

});
