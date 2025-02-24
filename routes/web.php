<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BulkActionController;
use App\Http\Controllers\Backend\Category\CategoryController;
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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'admin.auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

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

        Route::post('/delete-items', [BulkActionController::class, 'deleteItems'])->name('delete.items');

        // route logout
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // categories routes
        Route::resources([
            'categories' => CategoryController::class
        ]);

        // Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        // Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        // Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        // Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        // Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    });
});
