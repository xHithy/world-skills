<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/XX_module_c/admin');
});

Route::prefix('/XX_module_c')->group(function() {
    Route::get('/admin', [AdminController::class, 'panel']);
    Route::get('/user/{$username}', [UserController::class, 'profile']);
    Route::get('/game/{$slug}', [GameController::class, 'page']);
});
