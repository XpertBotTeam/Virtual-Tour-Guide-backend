<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\TourController;
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
});
// Auth Routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('tours',[TourController::class,'index']);
    Route::post('createTour',[TourController::class,'store']);
    Route::get('tours/{tour:id}',[TourController::class,'show']);
    Route::put('tours/{tour:id}',[TourController::class,'update']);
    Route::delete('tours/{tour:id}',[TourController::class,'destroy']);
    Route::post('tours/{tour}/reviews',[ReviewController::class,'store']);
    Route::delete('reviews/{review}', [ReviewController::class,'destroy']);
    Route::post('createCategory',[CategoryController::class,'store']);
    Route::delete('categories/{category}',[CategoryController::class,'destroy']);
    });

