<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MealController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//INFO  API scaffolding installed. Please add the [Laravel\Sanctum\HasApiTokens] trait to your User model.


Route::apiResource('customer',CustomerController::class);
Route::apiResource('meal',MealController::class);

