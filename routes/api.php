<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\FragranceController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::middleware('auth:admin_api')->group(function () {
        Route::post('/', 'store');
        Route::post('update/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::middleware('auth:user_api')->group(function () {
        Route::get('/', 'getAllProduct');
        Route::get('/{id}', 'show');
    });
});


Route::prefix('admin')->controller(AdminAuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::middleware('auth:admin_api')->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('me', 'me');
        Route::prefix('brand')->controller(BrandsController::class)->group(function () {
            Route::get('get-brands', 'getAllBrand');
            Route::post('store', 'store');
            Route::post('create', 'create');
            Route::get('/{id}', 'show');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('fragrance')->controller(FragranceController::class)->group(function () {
            Route::get('get-all', 'getAll');
            Route::post('store', 'store');
            Route::post('create', 'create');
            Route::get('/{id}', 'show');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('capacity')->controller(CapacityController::class)->group(function () {
            Route::get('get-all', 'getAll');
            Route::post('create', 'create');
            Route::post('update', 'update');
            Route::delete('/{id}', 'delete');
        });
        Route::prefix('product')->controller(ProductController::class)->group(function () {
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
    Route::middleware('auth:admin_api')->group(function () {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });
});
