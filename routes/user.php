<?php


use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;


route::get('/', [HomeController::class, 'home'])->name('home');

route::get('contents/{slug?}', [ContentController::class, 'content'])->name('content');

route::get('{paramOne?}/{paramTwo?}/{paramThree?}', [ProductController::class, 'productList'])->name('products');
