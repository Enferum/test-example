<?php

use App\Http\Controllers\Api\Client\AuthController as ClientLoginController;
use App\Http\Controllers\Api\User\AuthController as UserLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group( function () {
    Route::post('login', [UserLoginController::class, 'login']);
});

Route::prefix('client')->group( function() {
    Route::post('auth', [ClientLoginController::class, 'getCode']);
    Route::post('login', [ClientLoginController::class, 'login'])->name('login');
});


Route::post('1/{code}', [ClientLoginController::class, 'checkOtp']);
