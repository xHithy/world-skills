<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/XX_module_c/admin');
});

Route::prefix('/XX_module_c')->group(function() {
    Route::post('/admin', [AdminController::class, 'login']);
    Route::get('/admin', [AdminController::class, 'loginScreen'])->name('login');
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('panel')->middleware('verifyAdmin');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('users')->middleware('verifyAdmin');
    Route::get('/admin/games', [AdminController::class, 'games'])->name('games')->middleware('verifyAdmin');
    Route::post('/admin/games', [AdminController::class, 'searchGames'])->middleware('verifyAdmin');
    Route::get('/admin/scores/{slug}', [AdminController::class, 'scores'])->name('scores')->middleware('verifyAdmin');
    Route::get('/admin/versions/{slug}', [AdminController::class, 'versions'])->name('versions')->middleware('verifyAdmin');
    Route::get('/user/{username}', [UserController::class, 'profile']);
    Route::get('/game/{slug}', [GameController::class, 'page']);
});

Route::fallback(function () {
    return response()->json([
        "status" => "not-found",
        "message" => "not-found"
    ], 404);
});
