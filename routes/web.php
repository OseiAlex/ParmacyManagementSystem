<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MeasuringUnitController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route((Auth::user()->is_admin ? 'admin' : 'dispensary') . '.dashboard.index');
})->middleware(['auth'])->name('dashboard');

// admin route
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // home routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('index');
    });

    // home routes
    Route::prefix('activity-log')->name('activity.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])
            ->name('index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //    sales route
    Route::prefix('sales')->name('sale.')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/fetch', [SaleController::class, 'fetch'])->name('fetch');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::post('/edit', [SaleController::class, 'edit'])->name('edit');
        Route::put('/{uuid}/update', [SaleController::class, 'update'])->name('update');
        Route::post('/destroy', [SaleController::class, 'destroy'])->name('destroy');
    });

    // user routes
    Route::prefix('manage-users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/fetch', [UserController::class, 'fetch'])->name('fetch');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::post('/edit-profile', [UserController::class, 'editProfile'])->name('edit.profile');
        Route::put('/{user}/update-profile', [UserController::class, 'updateProfile'])->name('update.profile');
        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('update.password');
        Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');
    });
    // end of user routes

    // setup routes
    Route::prefix('setup')->name('setup.')->group(function () {
        //    product categories route
        Route::prefix('product-categories')->name('product_category.')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
            Route::get('/fetch', [ProductCategoryController::class, 'fetch'])->name('fetch');
            Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
            Route::post('/edit', [ProductCategoryController::class, 'edit'])->name('edit');
            Route::put('/{uuid}/update', [ProductCategoryController::class, 'update'])->name('update');
            Route::post('/destroy', [ProductCategoryController::class, 'destroy'])->name('destroy');
        });

        //    measuring unit route
        Route::prefix('measuring-unit')->name('measuring_unit.')->group(function () {
            Route::get('/', [MeasuringUnitController::class, 'index'])->name('index');
            Route::get('/fetch', [MeasuringUnitController::class, 'fetch'])->name('fetch');
            Route::post('/', [MeasuringUnitController::class, 'store'])->name('store');
            Route::post('/edit', [MeasuringUnitController::class, 'edit'])->name('edit');
            Route::put('/{uuid}/update', [MeasuringUnitController::class, 'update'])->name('update');
            Route::post('/destroy', [MeasuringUnitController::class, 'destroy'])->name('destroy');
        });

        // //    suppliers route
        // Route::prefix('suppliers')->name('supplier.')->group(function () {
        //     Route::get('/', [SupplierController::class, 'index'])->name('index');
        //     Route::get('/fetch', [SupplierController::class, 'fetch'])->name('fetch');
        //     Route::post('/', [SupplierController::class, 'store'])->name('store');
        //     Route::post('/edit', [SupplierController::class, 'edit'])->name('edit');
        //     Route::put('/{uuid}/update', [SupplierController::class, 'update'])->name('update');
        //     Route::post('/destroy', [SupplierController::class, 'destroy'])->name('destroy');
        // });
    });

    // end of setup routes

    // inventory routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        //    products route
        Route::prefix('products')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/fetch', [ProductController::class, 'fetch'])->name('fetch');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::post('/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{uuid}/update', [ProductController::class, 'update'])->name('update');
            Route::post('/destroy', [ProductController::class, 'destroy'])->name('destroy');
            Route::post('/enlist', [ProductController::class, 'enlist'])->name('enlist');
            Route::post('/import', [ProductController::class, 'import'])->name('import');
        });

        //    pricing route
        Route::prefix('pricing-list')->name('pricing.')->group(function () {
            Route::get('/', [InventoryController::class, 'showPricing'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchPricingProducts'])->name('fetch');
            Route::post('/', [InventoryController::class, 'store'])->name('store');
            Route::post('/edit', [InventoryController::class, 'pricingEdit'])->name('edit');
            Route::put('/{uuid}/update', [InventoryController::class, 'pricingUpdate'])->name('update');
        });

        //    stock levels route
        Route::prefix('stock-levels')->name('stock.')->group(function () {
            Route::get('/', [InventoryController::class, 'showStockLevel'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchProducts'])->name('fetch');
            Route::post('/', [InventoryController::class, 'store'])->name('store');
            Route::post('/edit', [InventoryController::class, 'stockLevelEdit'])->name('edit');
            Route::put('/{uuid}/update', [InventoryController::class, 'stockLevelUpdate'])->name('update');
        });

        // //    top products route
        // Route::prefix('top-products')->name('top.')->group(function () {
        //     Route::get('/', [InventoryController::class, 'showTopProducts'])->name('index');
        //     Route::get('/fetch', [InventoryController::class, 'fetchTopProducts'])->name('fetch');
        // });

        //    expired products route
        Route::prefix('expired-products')->name('expired.')->group(function () {
            Route::get('/', [InventoryController::class, 'showExpiryProducts'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchExpiredProducts'])->name('fetch');
        });
    });
    // end of inventory routes
});

// dispensary route
Route::prefix('dispensary')->name('dispensary.')->middleware('dispensary')->group(function () {
    // home routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //    sales route
    Route::prefix('sales')->name('sale.')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/fetch', [SaleController::class, 'fetch'])->name('fetch');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::post('/edit', [SaleController::class, 'edit'])->name('edit');
        Route::put('/{uuid}/update', [SaleController::class, 'update'])->name('update');
        Route::post('/destroy', [SaleController::class, 'destroy'])->name('destroy');
    });

    // inventory routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        //    pricing route
        Route::prefix('pricing-list')->name('pricing.')->group(function () {
            Route::get('/', [InventoryController::class, 'showPricing'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchPricingProducts'])->name('fetch');
        });

        //    stock levels route
        Route::prefix('stock-levels')->name('stock.')->group(function () {
            Route::get('/', [InventoryController::class, 'showStockLevel'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchProducts'])->name('fetch');
        });

        //    expired products route
        Route::prefix('expired-products')->name('expired.')->group(function () {
            Route::get('/', [InventoryController::class, 'showExpiryProducts'])->name('index');
            Route::get('/fetch', [InventoryController::class, 'fetchExpiredProducts'])->name('fetch');
        });
    });
});

require __DIR__ . '/auth.php';
