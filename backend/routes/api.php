<?php

use App\Http\Controllers\Api\V1\Addresses\CountryController;
use App\Http\Controllers\Api\V1\Addresses\DeliveryPlaceController;
use App\Http\Controllers\Api\V1\Addresses\DistrictController;
use App\Http\Controllers\Api\V1\Addresses\RegionController;
use App\Http\Controllers\Api\V1\Addresses\SettlementController;
use App\Http\Controllers\Api\V1\Books\AudioFormatController;
use App\Http\Controllers\Api\V1\Books\AuthorController;
use App\Http\Controllers\Api\V1\Books\BookController;
use App\Http\Controllers\Api\V1\Books\CategoryController;
use App\Http\Controllers\Api\V1\Books\ElectronicFormatController;
use App\Http\Controllers\Api\V1\Books\FragmentController;
use App\Http\Controllers\Api\V1\Books\PaperFormatController;
use App\Http\Controllers\Api\V1\Books\PublisherController;
use App\Http\Controllers\Api\V1\Books\ReviewController;
use App\Http\Controllers\Api\V1\Orders\OrderController;
use App\Http\Controllers\Api\V1\Orders\PaymentMethodController;
use App\Http\Controllers\Api\V1\Orders\ShippingMethodController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Http\Controllers\AuthController;
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


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){

    Route::group(['namespace' => 'Books'], function(){
        Route::apiResource('publishers', PublisherController::class);
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('fragments', FragmentController::class);
        Route::apiResource('reviews', ReviewController::class);

        Route::get('categories/flat', [CategoryController::class, 'getFlat']);
        Route::get('categories/{category}/siblings', [CategoryController::class, 'getSiblings']);
        Route::get('categories/{category}/siblingsAndSelf', [CategoryController::class, 'getSiblingsAndSelf']);
        Route::get('categories/{parentCategory}/children', [CategoryController::class, 'getChildren']);
        Route::apiResource('categories', CategoryController::class);
        Route::post('categories/{parentCategory}', [CategoryController::class, 'storeForParent']);

        Route::get('books/languages', [BookController::class, 'getLanguages']);
        Route::apiResource('books', BookController::class);
        Route::delete('books/{book}/coverImage', [BookController::class, 'deleteCoverImage']);
        Route::delete('books/{book}/{format}', [BookController::class, 'deleteFormat']);
        Route::get('books/{book}/reviews', [BookController::class, 'getReviews']);
        Route::get('books/{book}/fragments', [BookController::class, 'getPreviewFragments']);
        Route::get('books/{book}/related', [BookController::class, 'getRelatedBooks']);
        Route::get('books/{book}/paper', [BookController::class, 'getPaperFormat']);
        Route::get('books/{book}/electronic', [BookController::class, 'getElectronicFormat']);
        Route::get('books/{book}/audio', [BookController::class, 'getAudioFormat']);


        Route::get('books/electronic/{book}/download/{extension}', [BookController::class, 'downloadElectronicBook']);
        Route::get('books/audio/{book}/download/{extension}', [BookController::class, 'downloadAudioBook']);
        Route::post('books/upload/electronic', [BookController::class, 'uploadElectronicFiles']);
        Route::post('books/upload/audio', [BookController::class, 'uploadAudioFiles']);
        Route::post('books/{book}/uploadCoverImage', [BookController::class, 'uploadCoverImage']);
        Route::delete('books/electronic/{book}/{extension}', [BookController::class, 'deleteElectronicFile']);
        Route::delete('books/audio/{book}/{extension}', [BookController::class, 'deleteAudioFile']);
        
        Route::apiResource('paperFormats', PaperFormatController::class)->except(['store']);
        Route::post('paperFormats/{book}', [PaperFormatController::class, 'storeForBook']);

        Route::apiResource('audioFormats', AudioFormatController::class)->except(['store']);
        Route::post('audioFormats/{book}', [AudioFormatController::class, 'storeForBook']);

        Route::apiResource('electronicFormats', ElectronicFormatController::class)->except(['store']);
        Route::post('electronicFormats/{book}', [ElectronicFormatController::class, 'storeForBook']);
    });

    Route::group(['namespace' => 'Addresses'], function(){
        Route::apiResource('countries', CountryController::class);
        Route::apiResource('regions', RegionController::class);
        Route::apiResource('districts', DistrictController::class);
        Route::apiResource('settlements', SettlementController::class);
        Route::apiResource('deliveryPlaces', DeliveryPlaceController::class);
        Route::get('deliveryPlaces/{deliveryPlace}/fullAddress', [DeliveryPlaceController::class, 'getFullAddress']);
    });

    Route::group(['namespace' => 'Orders'], function(){
        Route::apiResource('shippingMethods',ShippingMethodController::class);
        Route::get('orders/creationInfo', [OrderController::class, 'getCreationInfo']);
        Route::get('orders/categoriesStat', [OrderController::class, 'getCategoriesStat']);
        Route::get('orders/bookFormatsStat', [OrderController::class, 'getBookFormatsStat']);
        Route::apiResource('orders', OrderController::class);
        Route::get('orders/{order}/details', [OrderController::class, 'showDetails']);
        Route::post('orders/createOnlinePaymentOrder', [OrderController::class, 'createOnlinePaymentOrder']);
        Route::post('orders/confirmOnlinePaymentOrder', [OrderController::class, 'confirmOnlinePaymentOrder']);
        Route::get('paymentMethods', [PaymentMethodController::class, 'index']);
    });

    Route::group(['namespace' => 'Users'], function(){
        Route::get('users/registration', [UserController::class, 'getRegistrationInfo']);
        Route::apiResource('users', UserController::class);
        Route::get('users/{user}/orders', [UserController::class, 'getOrders']);
        Route::get('users/{user}/details', [UserController::class, 'getDetails']);
        Route::get('users/{user}/electronicBooks', [UserController::class, 'getElectronicBooks']);
        Route::get('users/{user}/audioBooks', [UserController::class, 'getAudioBooks']);
        Route::get('users/{user}/likedBooks', [UserController::class, 'getLikedBooks']);
        Route::post('users/{user}/like/{book}', [UserController::class, 'likeBook']);
        Route::post('users/{user}/unlike/{book}', [UserController::class, 'unlikeBook']);
    });
});
