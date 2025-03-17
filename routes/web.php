<?php

use App\Http\Controllers\Backend\Attribute\AttributeController;
use App\Http\Controllers\Backend\Attribute\AttributeValueController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\Brand\BrandController;
use App\Http\Controllers\Backend\BulkActionController;
use App\Http\Controllers\Backend\Category\CategoryController;
use App\Http\Controllers\Backend\Order\OrderController;
use App\Http\Controllers\Backend\Post\PostController;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\Backend\Slider\SliderController;
use App\Http\Controllers\Backend\Variation\VariationController;
use App\Http\Controllers\Backend\Config\ConfigController;
use App\Http\Controllers\Backend\FastUpdateController;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


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

    route::get('import-data', function () {
        return view('backend.import');
    });

    route::post('import-data', function (Request $request) {
        Excel::import(new ProductsImport, $request->file('file'));
    })->name('import-data');

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
            'products' => ProductController::class,
            'variations' => VariationController::class,
            'sliders' => SliderController::class,
            'posts' => PostController::class,
        ]);

        Route::prefix('configs')->controller(ConfigController::class)->name('configs.')->group(function () {
            Route::get('/', 'config')->name('config');
            Route::post('/', 'postConfig')->name('post_config');

            route::get('payments/{id?}', 'payment')->name('payment');
            route::put('payments', 'handleChangePublishPayment')->name('handleChangePublishPayment');
            route::post('config-transfer-payment',  'configTransferPayment')->name('configTransferPayment');

            route::get('/filters', 'filter')->name('filter');
            route::post('/filters', 'handleSubmitFilter')->name('handleSubmitFilter');
            route::post('config-filter-update/{id}', 'handleSubmitChangeFilter')->name('handleSubmitChangeFilter');
        });

        Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
            Route::get('/',  'index')->name('index');
            Route::get('/{order}',  'show')->name('show');
            Route::post('updateStatus',  'updateOrderStatus')->name('updateOrderStatus');
            Route::post('export-pdf',  'exportPDF')->name('exportPDF');
            route::post('change-status', 'changeOrderStatus')->name('change-order-status');
            route::post('cancel-order/{id}', 'cancelOrder')->name('cancel-order');
            route::get('confirm-payment/{id}', 'confirmPayment')->name('confirm-payment');
            route::get('ransfer-history', 'transferHistory')->name('transfer-history');
        });

        Route::get('attributes-values/{id}', [AttributeValueController::class, 'index'])->name('attributes-values.index');
        Route::post('attributes-values/{id}', [AttributeValueController::class, 'store'])->name('attributes-values.store');
        Route::put('attributes-values/{id}', [AttributeValueController::class, 'update'])->name('attributes-values.update');

        Route::post('variations-attributes-values', [VariationController::class, 'variationAttributes'])->name('variations.attributes-values');
        Route::get('variations/product/{id}', [VariationController::class, 'variationProduct'])->name('variations.product.index');
        Route::get('variations/product/{id}/create', [VariationController::class, 'variationProductCreate'])->name('variations.product.create');
        Route::get('variations/product/{id}/edit/{id1}', [VariationController::class, 'variationProductEdit'])->name('variations.product.edit');
    });
});
