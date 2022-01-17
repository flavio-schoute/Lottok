<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GambleController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountsController;
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

    // List of all the games and create a gamble
    Route::resource('games', GameController::class);

    // The gamble itself
    Route::resource('gamble', GambleController::class);

    Route::resource('statistic', StatisticsController::class);
    Route::resource('accounts', AccountsController::class);
    Route::resource('pay', PaymentController::class);
    Route::resource('cashout', CashoutController::class);

    Route::resource('pay', PaymentController::class);
    Route::resource('cashout', CashoutController::class);

    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::resource('statistic', StatisticsController::class);
        Route::resource('accounts', AccountsController::class);
    });
});

Route::stripeWebhooks('stripe-webhook');

