<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;

route::middleware('guest')->group(function () {
    route::get('einloggen', [AuthController::class, 'login'])->name('login');

    route::post('einloggen', [AuthController::class, 'authenticate']);

    route::get('registrieren', [AuthController::class, 'register'])->name('register');

    route::post('registrieren', [AuthController::class, 'postRegister']);
});



route::get('/', [HomeController::class, 'home'])->name('home');

route::get('contents/{slug?}', [ContentController::class, 'content'])->name('content');

route::post('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');

route::get('warenkorb/show', [CartController::class, 'cartList'])->name('cartList');

route::post('update-cart', [CartController::class, 'updateCart']);

route::get('zahlen', [CheckoutController::class, 'checkout'])->name('checkout');

route::post('zahlen', [CheckoutController::class, 'postCheckout'])->name('postCheckout');

route::get('erfolg/{code}', [CheckoutController::class, 'orderSuccess'])->name('orderSuccess');

route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

route::get('meinkonto', [AuthController::class, 'myInfo'])->name('myInfo')->middleware('auth');

route::get('shop/marken/{slug?}', [BrandController::class, 'index'])->name('marken');

route::get('redirect/{code}', [ProductController::class, 'redirect'])->name('redirect');

route::get('{paramOne?}/{paramTwo?}/{paramThree?}', [ProductController::class, 'productList'])->name('products');
