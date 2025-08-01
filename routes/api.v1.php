<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\BrandModelController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ColorController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthenticationController::class)->prefix("auth/customer")->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'loginCustomer');
    Route::post('verify', 'verifyRegisterCode');
});
Route::post('auth/resend-verification', [AuthenticationController::class, 'resendVerificationCode']);



Route::get('brands', [BrandController::class, 'getBrands']);
Route::get('models', [BrandModelController::class, 'getModels']);
Route::get("colors", [ColorController::class, 'getColors']);
Route::get('brand/models', [BrandModelController::class, 'getModelsByBrand']);
Route::get('cars', [CarController::class, 'getCars']);