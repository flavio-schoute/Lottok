<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GambleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::middleware(['auth', 'auth:sanctum', 'verified'])->prefix('dashboard')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    
    //Route::get('/gamble', [GambleController::class, 'index'])->name('gamble');

    Route::resource('gamble', GambleController::class);

    Route::resource('statistic', StatisticsController::class);
    // Route::resource('game', GameController::class);
});
