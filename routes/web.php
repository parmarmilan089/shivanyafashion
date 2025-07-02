<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CustomerAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/product/{id}', [FrontendController::class, 'product'])->name('product');
Route::view('/terms-and-conditions', 'front.pages.terms-and-conditions')->name('front.terms');
Route::view('/about-us', 'front.pages.about')->name('front.about');
Route::view('/contact-us', 'front.pages.contact')->name('front.contact');
Route::view('/privacy-policy', 'front.pages.privacy')->name('front.privacy');
Route::get('customer/register', [CustomerAuthController::class, 'showRegisterForm']);
Route::post('customer/register', [CustomerAuthController::class, 'register'])->name('customer.register');

Route::get('customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('customer/login', [CustomerAuthController::class, 'login']);

Route::get('customer/logout', [CustomerAuthController::class, 'logout']);

Route::middleware('auth:customer')->group(function () {
    Route::get('/store', function () {
        return view('front.store.index');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/meesho-label-upload', [AdminController::class, 'upload'])->name('meesho.label.upload');

    Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('/order/show/{id}', [OrderController::class, 'showOrder'])->name('admin.order.show');
    Route::get('/order/create', [OrderController::class, 'createOrder'])->name('admin.order.create');
    Route::post('/order/store', [OrderController::class, 'storeOrder'])->name('admin.order.store');
    Route::delete('/order/delete/{id}', [OrderController::class, 'deleteOrder'])->name('admin.order.destroy');
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('admin.orders.export');

    //update the product price with the order data
    Route::get('/orders/update-order/{productprice}/{product_id}', [OrderController::class, 'updateProductPrice']);



    Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.destroy');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');

    Route::get('/update-payment-status', [OrderController::class, 'updatePaymentStatusForReturns'])->name('admin.updatePaymentStatusForReturns');

    Route::prefix('admin')->name('admin.')->group(function () {

        // Resourceful routes for category module
        Route::resource('categories', CategoryController::class)->except(['show']);

        
        Route::get('categories/get-subcategories', [CategoryController::class, 'getSubcategories'])->name('get-subcategories');
        Route::get('categories/get-subsubcategories', [CategoryController::class, 'getSubsubcategories'])->name('get-subsubcategories');

        // AJAX route to get children of a category (for cascading dropdown)
        Route::get('categories/children/{parent?}', function (?App\Models\Category $parent) {
            return $parent
                ? $parent->children()->select('id', 'name')->get()
                : \App\Models\Category::main()->select('id', 'name')->get();
        })->name('categories.children');

    });

});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('inventory', InventoryController::class);
});
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('payment', PaymentController::class)->names('payment');
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('size', SizeController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('color', ColorController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('banner', BannerController::class);
});
require __DIR__.'/auth.php';

