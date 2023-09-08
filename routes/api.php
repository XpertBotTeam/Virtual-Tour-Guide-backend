<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\TourController;
use App\Http\Controllers\API\TourUserController;
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
// Guest Routes
Route::group(['middleware' => 'guest'], function () {
    Route::post('register',[AuthController::class,'store']);
    Route::post('login',[AuthController::class,'login']);
    Route::get('getTours', [TourController::class, 'index']);
    Route::get('getTours/{tour}', [TourController::class, 'show']);
});
// Auth Routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::group(['middleware'=>'admin'],function(){
        Route::resource('tours',TourController::class);
        Route::resource('categories',CategoryController::class);
    });
    Route::resource('userTours', TourUserController::class);
    Route::post('tours/{tour}/reviews', [ReviewController::class, 'store']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);
});

