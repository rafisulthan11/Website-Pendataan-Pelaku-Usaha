<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/public.php';

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'prevent.back'])
    ->name('dashboard');

Route::middleware(['auth', 'prevent.back'])->group(function () {
    require __DIR__ . '/web/profile.php';
    require __DIR__ . '/web/users.php';
    require __DIR__ . '/web/master-data.php';
    require __DIR__ . '/web/operational.php';
    require __DIR__ . '/web/analytics-reports.php';
});

require __DIR__.'/auth.php';
