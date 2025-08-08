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


// Customer Auth Apis
Route::controller(AuthenticationController::class)->name('customer')->prefix("auth/customer")->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('.login');
    Route::post('verify', 'verifyRegisterCode');
    Route::post('forget-password','forgetPassword')->name('.forget');
    Route::delete('logout', 'logout')->middleware('auth:'.authGuardEnum::Customer->value)->name('customer.logout');
});
// User Auth Apis
Route::controller(AuthenticationController::class)->name('user')->prefix("auth/user")->group(function () {
    Route::post('login', 'login')->name('.login');
    Route::post('forget-password','forgetPassword')->name('.forget');
    Route::post('verify-reset','verifyPasswordRecoveryCode')->name('.verify-reset');
    Route::post('reset-password','resetPassword')->name('.reset-password');
    Route::delete('logout', 'logout')->middleware('auth:'.authGuardEnum::User->value)->name('user.logout');
    
});
Route::controller(UserActivityController::class)->prefix('user')->middleware('auth:'.authGuardEnum::User->value)->group(function(){
    Route::post('check-in','checkIn');
    Route::get('check-out','checkOut');
});
Route::post('auth/resend-verification', [AuthenticationController::class, 'resendVerificationCode']);

Route::controller(SellingRequestController::class)->middleware("auth:sanctum")->group(function () {
    Route::post('create', 'create');
});


Route::get('brands', [BrandController::class, 'getBrands']);
Route::get('models', [BrandModelController::class, 'getModels']);
Route::get("colors", [ColorController::class, 'getColors']);
Route::get('brand/models', [BrandModelController::class, 'getModelsByBrand']);
Route::get('cars', [CarController::class, 'getCars']);