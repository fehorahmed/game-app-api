<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'throttle:1000,10'], function () {

    Route::post('game-login', [AppUserAuthController::class, 'appLogin'])->name('api.app_user.login');
    Route::post('game-registration', [AppUserAuthController::class, 'appRegistration'])->name('api.app_user.register');
    Route::post('password/email', [AppUserAuthController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [AppUserAuthController::class, 'reset']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('profile', [AppUserController::class, 'profile']);

    });
});
