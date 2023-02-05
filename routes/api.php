<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1/auth/')->group(function() {
    Route::post('signup', [UserController::class, 'register']);
    Route::post('signin', [UserController::class, 'login']);
    Route::post('signout', [UserController::class, 'logout']);
});

Route::prefix('v1/games/')->group(function() {
    Route::get('', [GameController::class, 'index']);
});
