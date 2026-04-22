<?php

use Illuminate\Support\Facades\Route;

Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
