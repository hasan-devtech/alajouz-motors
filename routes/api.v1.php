<?php

use App\Enums\authGuardEnum;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\BrandModelController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\SellingRequestController;
use App\Http\Controllers\Api\UserActivityController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthenticationController::class)->prefix("auth/customer")->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'loginCustomer');
    Route::delete('logout', 'logoutCustomer')->middleware('auth:'.authGuardEnum::Customer->value);
    Route::post('verify', 'verifyRegisterCode');
});
// User Apis
Route::controller(AuthenticationController::class)->prefix("auth/user")->group(function () {
    Route::post('login', 'loginUser');
    Route::delete('logout', 'logoutUser')->middleware('auth:'.authGuardEnum::User->value);
});
Route::controller(UserActivityController::class)->prefix('user')->middleware('auth:'.authGuardEnum::User->value)->group(function(){
    Route::post('check-in','checkIn');
});
Route::post('auth/resend-verification', [AuthenticationController::class, 'resendVerificationCode']);

Route::controller(SellingRequestController::class)->middleware("auth:sanctum")->group(function () {
    Route::post('create', 'createSellingRequest');
});


Route::get('brands', [BrandController::class, 'getBrands']);
Route::get('models', [BrandModelController::class, 'getModels']);
Route::get("colors", [ColorController::class, 'getColors']);
Route::get('brand/models', [BrandModelController::class, 'getModelsByBrand']);
Route::get('cars', [CarController::class, 'getCars']);