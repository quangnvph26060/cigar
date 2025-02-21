<?php

use App\Http\Controllers\Backend\AuthController;
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

Route::prefix('admin')->name('admin.')->group(function () {

    // auth routes
    Route::prefix('auth')->middleware('admin.guest')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate');
    });

    Route::middleware('admin.auth')->group(function () {

        // route dashboard
        Route::get('', function () {
            return view('backend.dashboard');
        })->name('dashboard');

        // route logout
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});
