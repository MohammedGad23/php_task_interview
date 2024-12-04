<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//INFO  API scaffolding installed. Please add the [Laravel\Sanctum\HasApiTokens] trait to your User model.


Route::apiResource('customer',CustomerController::class);
Route::apiResource('tables',TableController::class);
Route::apiResource('waiters',WaiterController::class);

Route::post('check-availability',[ReservationController::class,'checkAvailability']);
Route::post('reservation',[ReservationController::class,'store']);
Route::apiResource('meals',MealController::class);
Route::apiResource('order',OrderController::class);

Route::get('checkout/{tableId}',[OrderController::class,'checkoutOrder']);
