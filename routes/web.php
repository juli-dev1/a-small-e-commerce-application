<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/products');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Products routes
Route::resource('products', ProductController::class);
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
Route::delete('remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove.from.cart');

//Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->middleware(['auth','cart-has-products'])->name('checkout');
Route::post('/checkout/order', [OrderController::class, 'placeOrder'])->middleware('auth')->name('checkout.place.order');
Route::get('/success', [OrderController::class, 'success'])->middleware('auth')->name('success');

Route::post('/apply-coupon', [OrderController::class, 'applyCoupon'])->middleware('auth')->name('apply-coupon');

