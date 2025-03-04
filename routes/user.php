<?php


use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;


route::get('/', [HomeController::class, 'home'])->name('home');
route::get('contents/{slug?}', [ContentController::class, 'content'])->name('content');
