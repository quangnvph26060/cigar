<?php

use App\Http\Controllers\Backend\Attribute\AttributeController;
use App\Http\Controllers\Backend\Attribute\AttributeValueController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\Brand\BrandController;
use App\Http\Controllers\Backend\BulkActionController;
use App\Http\Controllers\Backend\Category\CategoryController;
use App\Http\Controllers\Backend\Config\ConfigController;
use App\Http\Controllers\Backend\FastUpdateController;
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

    Route::put('handle-fast-update', [FastUpdateController::class, 'handleFastUpdate']);

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
        Route::post('/change-order', [BulkActionController::class, 'changeOrder']);

        // route logout
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // categories routes
        Route::resources([
            'categories' => CategoryController::class,
            'attributes' => AttributeController::class,
            'brands' => BrandController::class,
        ]);

        Route::prefix('configs')->controller(ConfigController::class)->name('configs.')->group(function () {
            Route::get('/', 'config')->name('config');
            Route::post('/', 'postConfig')->name('post_config');
        });

        Route::get('attributes-values/{id}', [AttributeValueController::class, 'index'])->name('attributes-values.index');
        Route::post('attributes-values/{id}', [AttributeValueController::class, 'store'])->name('attributes-values.store');
        Route::put('attributes-values/{id}', [AttributeValueController::class, 'update'])->name('attributes-values.update');
    });
});
