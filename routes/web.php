<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('/order/show/{id}', [OrderController::class, 'showOrder'])->name('admin.order.show');
    Route::get('/order/create', [OrderController::class, 'createOrder'])->name('admin.order.create');
    Route::post('/order/store', [OrderController::class, 'storeOrder'])->name('admin.order.store');
    Route::delete('/order/delete/{id}', [OrderController::class, 'deleteOrder'])->name('admin.order.destroy');



    Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('admin.product.destroy');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
});

require __DIR__.'/auth.php';

