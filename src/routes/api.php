<?php

use App\Http\Controllers\Api\V1\Addresses\AddressController;
use App\Http\Controllers\Api\V1\Addresses\CountryController;
use App\Http\Controllers\Api\V1\Addresses\DistrictController;
use App\Http\Controllers\Api\V1\Addresses\RegionController;
use App\Http\Controllers\Api\V1\Books\AuthorController;
use App\Http\Controllers\Api\V1\Books\BookController;
use App\Http\Controllers\Api\V1\Books\CategoryController;
use App\Http\Controllers\Api\V1\Books\FragmentController;
use App\Http\Controllers\Api\V1\Books\PublisherController;
use App\Http\Controllers\Api\V1\Books\ReviewController;
use App\Http\Controllers\Api\V1\Orders\OrderController;
use App\Http\Controllers\Api\V1\Orders\ShippingMethodController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){

    Route::group(['namespace' => 'Books'], function(){
        Route::apiResource('publishers', PublisherController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('authors', AuthorController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('fragments', FragmentController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('reviews', ReviewController::class)->missing(fn() => notFoundJsonResponse());

        Route::apiResource('categories', CategoryController::class)->missing(fn() => notFoundJsonResponse());
        Route::post('categories/{parentCategory}', [CategoryController::class, 'storeForParent'])->missing(fn() => notFoundJsonResponse());
    
        Route::apiResource('books', BookController::class)->missing(fn() => notFoundJsonResponse());
        Route::delete('books/{book}/{format}', [BookController::class, 'deleteFormat'])->missing(fn() => notFoundJsonResponse());
    });

    Route::group(['namespace' => 'Addresses'], function(){
        Route::apiResource('countries', CountryController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('regions', RegionController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('districts', DistrictController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('addresses', AddressController::class)->missing(fn() => notFoundJsonResponse());
    });

    Route::group(['namespace' => 'Orders'], function(){
        Route::apiResource('shippingMethods',ShippingMethodController::class)->missing(fn() => notFoundJsonResponse());
        Route::apiResource('orders', OrderController::class)->missing(fn() => notFoundJsonResponse());
        Route::get('orders/{order}/details', [OrderController::class, 'showDetails'])->missing(fn() => notFoundJsonResponse());
    });

    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::group(['namespace' => 'Users'], function(){
        Route::apiResource('users', UserController::class)->missing(fn() => notFoundJsonResponse());
    });
    
});
