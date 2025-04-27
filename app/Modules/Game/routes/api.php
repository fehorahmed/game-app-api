<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\Game\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('api/game/list', [GameController::class, 'apiGameList'])->name('api.game.list');
//For Game User
Route::group(['middleware' => 'throttle:1000,10'], function () {
    Route::post('normal-login', [AppUserAuthController::class, 'normalGameUserLogin'])->name('api.game.login');
    Route::post('normal-registration', [AppUserAuthController::class, 'normalGameUserRegistration'])->name('api.game.register');
    // Route::group(['middleware' => ['auth:sanctum', 'apiemailverified']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {

    });
});
