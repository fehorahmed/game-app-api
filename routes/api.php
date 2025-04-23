<?php

use App\Http\Controllers\GlobalConfigController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/get-configuration', [GlobalConfigController::class, 'getConfigByApi']);

    Route::get('/get-payment-method', [PaymentMethodController::class, 'getApiPaymentMethod']);
    Route::get('/browse', function () {
        return view('brawse');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    });
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);