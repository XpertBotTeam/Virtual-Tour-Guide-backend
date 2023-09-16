<?php

use App\Http\Controllers\API\AdminCategoryController;
use App\Http\Controllers\API\AdminTourController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SuperCategoryController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SuperTourController;
use App\Http\Controllers\API\TourUserController;
use App\Http\Controllers\UserTourController;
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
    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::get('Tours', [UserTourController::class, 'index']);
    Route::get('Tours/{tour}', [UserTourController::class, 'show']);
});
// Auth Routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::group(['middleware'=>'super'],function(){
        Route::resource('tours',SuperTourController::class);
        Route::resource('categories',SuperCategoryController::class);
    });
    Route::group(['middleware'=>'admin'],function(){
        Route::resource('adminTours', AdminTourController::class);
    });
    Route::post('tours/{tour}/reviews', [ReviewController::class, 'store']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);
});

