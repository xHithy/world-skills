<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/XX_module_c/admin');
});

Route::prefix('/XX_module_c')->group(function() {
    Route::get('/admin', [AdminController::class, 'panel']);
});
