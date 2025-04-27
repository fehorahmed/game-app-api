<?php

use App\Http\Controllers\HomeController;
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
