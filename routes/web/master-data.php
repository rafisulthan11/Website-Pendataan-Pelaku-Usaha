<?php

use Illuminate\Support\Facades\Route;

Route::middleware('is.admin')->group(function () {
    Route::resource('komoditas', \App\Http\Controllers\KomoditasController::class);
    Route::resource('pasar', \App\Http\Controllers\PasarController::class);
});
