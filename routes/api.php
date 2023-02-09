<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication API routes
Route::prefix('v1/auth/')->group(function() {
    Route::post('signup', [UserController::class, 'register']);
    Route::post('signin', [UserController::class, 'login']);
    Route::post('signout', [UserController::class, 'logout'])->middleware('verifyToken');
});

// Game API routes
Route::prefix('v1/games')->group(function() {
    Route::get('/', [GameController::class, 'allGames']);
    Route::get('/{slug}/{version}/', [GameController::class, 'serveGame']);
    Route::get('/{slug}', [GameController::class, 'showGame']);
    Route::get('/{slug}/scores', [GameController::class, 'showScores']);
    Route::post('/', [GameController::class, 'createGame'])->middleware('verifyToken');
    Route::post('/{slug}/upload', [GameController::class, 'uploadGame'])->middleware('verifyToken');
    Route::put('/{slug}', [GameController::class, 'updateGame'])->middleware('verifyToken');
    Route::delete('/{slug}', [GameController::class, 'removeGame'])->middleware('verifyToken');
    Route::post('/{slug}/scores', [GameController::class, 'uploadScores'])->middleware('verifyToken');
});

Route::prefix('v1/users/')->group(function() {
    Route::get('{$username}', [UserController::class, 'showUser'])->middleware('verifyToken');
});
