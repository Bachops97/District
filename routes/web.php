<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


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
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


//products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
Route::get('/products/my-listing', [ProductController::class, 'userProducts'])->name('userProducts');
Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');

Route::delete('/products/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/products/create/post', [ProductController::class, 'store'])->name('product.store');
Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('product.update');

//cart
Route::get('/cart', [CartController::class , 'viewCart'])->name('cart.index');

Route::post('/cart/add', [CartController::class , 'addToCart'])->name('cart.add');
Route::put('/cart/update/{cartItem}', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

