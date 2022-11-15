<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CapacityController as AdminCapacityController;
use App\Http\Controllers\Admin\FragranceController as AdminFragranceController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\BrandController as UserBrandController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('admin')->controller(AdminAuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::middleware('auth:admin_api')->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('me', 'me');
        Route::prefix('brand')->controller(AdminBrandController::class)->group(function () {
            Route::get('get-brands', 'getAllBrand');
            Route::post('store', 'store');
            Route::post('create', 'create');
            Route::get('/{id}', 'show');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('fragrance')->controller(AdminFragranceController::class)->group(function () {
            Route::get('get-all', 'getAll');
            Route::post('store', 'store');
            Route::post('create', 'create');
            Route::get('/{id}', 'show');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('capacity')->controller(AdminCapacityController::class)->group(function () {
            Route::get('get-all', 'getAll');
            Route::post('create', 'create');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('product')->controller(AdminProductController::class)->group(function () {
            Route::get('get-all', 'getAll');
            Route::get('{id}', 'show');
            Route::post('create', 'create');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
    });
});

Route::prefix('user')->controller(UserAuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::middleware('auth:user_api')->group(function () {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });

    Route::prefix('brand')->controller(UserBrandController::class)->group(function () {
        Route::get('get-brands', 'getAllBrand');
    });
    Route::prefix('capacity')->controller(CapacityController::class)->group(function () {
        Route::get('get-all', 'getAll');
    });
    Route::prefix('product')->controller(UserProductController::class)->group(function () {
        Route::get('get-all', 'getAll');
        Route::get('{id}', 'show');
    });
});
