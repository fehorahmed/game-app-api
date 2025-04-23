<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppBannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalConfigController;
use App\Http\Controllers\HelpVideoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeSlideController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StarConfigController;
use App\Modules\Website\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
// Route::get('/migrate', function () {
//     Artisan::call('migrate');
// });
Route::get('/optimize', function () {
    Artisan::call('optimize');
});

require __DIR__ . '/auth.php';
