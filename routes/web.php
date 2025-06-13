<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
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

Route::get('/', function () {
    return view('welcome');
});

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
    
});
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('payment', PaymentController::class)->names('payment');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('banner', BannerController::class);
});
require __DIR__.'/auth.php';

