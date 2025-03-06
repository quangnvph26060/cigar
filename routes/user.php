<?php


use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;


route::get('/', [HomeController::class, 'home'])->name('home');

route::get('contents/{slug?}', [ContentController::class, 'content'])->name('content');

route::post('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');

route::get('warenkorb/show', [CartController::class, 'cartList'])->name('cartList');
route::post('update-cart', [CartController::class, 'updateCart']);

route::get('{paramOne?}/{paramTwo?}/{paramThree?}', [ProductController::class, 'productList'])->name('products');
