<?php

use Illuminate\Support\Facades\Route;



Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::get('/shop',[\App\Http\Controllers\ShopController::class,'index'])->name('shop');

Route::get('/shop/{product}',[\App\Http\Controllers\ProductController::class,'singleProduct'])->name('product.show');

Route::get('/cart',[\App\Http\Controllers\CartController::class,'index'])->name('cart');

Route::post('/add-to-cart/{product}',[\App\Http\Controllers\CartController::class,'addToCart'])->name('cart.add');

Route::get('empty',function (){
    \Darryldecode\Cart\Facades\CartFacade::clear();
});


Route::post('/cart/remove/{product_id}',[\App\Http\Controllers\CartController::class,'removeFromCart'])->name('cart.remove');
Route::patch('/cart/update/{product}',[\App\Http\Controllers\CartController::class,'updateQuantity'])->name('cart.update');

Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class,'store'])->name('checkout.store');
Route::get('/confirmation', [\App\Http\Controllers\ConfirmationController::class,'index'])->name('confirmation.index');


Route::post('/coupon', [\App\Http\Controllers\CouponController::class,'store'])->name('coupon.store');
Route::delete('/coupon', [\App\Http\Controllers\CouponController::class,'destroy'])->name('coupon.delete');
