<?php

use Illuminate\Support\Facades\Route;

// API routes for dependent dropdowns
Route::get('/api/desa-by-kecamatan/{id_kecamatan}', [\App\Http\Controllers\PembudidayaController::class, 'getDesaByKecamatan'])->name('api.desa.by.kecamatan');
Route::get('/api/pasar-by-desa/{id_desa}', [\App\Http\Controllers\HargaIkanSegarController::class, 'getPasarByDesa'])->name('api.pasar.by.desa');

// Verification routes (admin/super admin only)
Route::middleware('is.verification.admin')->group(function () {
    Route::post('/pembudidaya/{pembudidaya}/verify', [\App\Http\Controllers\PembudidayaController::class, 'verify'])->name('pembudidaya.verify');
    Route::post('/pembudidaya/{pembudidaya}/reject', [\App\Http\Controllers\PembudidayaController::class, 'reject'])->name('pembudidaya.reject');
    Route::post('/pengolah/{pengolah}/verify', [\App\Http\Controllers\PengolahController::class, 'verify'])->name('pengolah.verify');
    Route::post('/pengolah/{pengolah}/reject', [\App\Http\Controllers\PengolahController::class, 'reject'])->name('pengolah.reject');
    Route::post('/pemasar/{pemasar}/verify', [\App\Http\Controllers\PemasarController::class, 'verify'])->name('pemasar.verify');
    Route::post('/pemasar/{pemasar}/reject', [\App\Http\Controllers\PemasarController::class, 'reject'])->name('pemasar.reject');
    Route::post('/harga-ikan-segar/{hargaIkanSegar}/verify', [\App\Http\Controllers\HargaIkanSegarController::class, 'verify'])->name('harga-ikan-segar.verify');
    Route::post('/harga-ikan-segar/{hargaIkanSegar}/reject', [\App\Http\Controllers\HargaIkanSegarController::class, 'reject'])->name('harga-ikan-segar.reject');
});

// Notification routes
Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');

Route::middleware('is.staff')->group(function () {
    Route::resource('pembudidaya', \App\Http\Controllers\PembudidayaController::class)->only(['create', 'store', 'edit', 'update']);
    Route::resource('pengolah', \App\Http\Controllers\PengolahController::class)->only(['create', 'store', 'edit', 'update']);
    Route::resource('pemasar', \App\Http\Controllers\PemasarController::class)->only(['create', 'store', 'edit', 'update']);
    Route::resource('harga-ikan-segar', \App\Http\Controllers\HargaIkanSegarController::class)->only(['create', 'store', 'edit', 'update']);
});

// Read-only routes for authenticated users
Route::resource('pembudidaya', \App\Http\Controllers\PembudidayaController::class)->only(['index', 'show']);
Route::resource('pengolah', \App\Http\Controllers\PengolahController::class)->only(['index', 'show']);
Route::resource('pemasar', \App\Http\Controllers\PemasarController::class)->only(['index', 'show']);
Route::resource('harga-ikan-segar', \App\Http\Controllers\HargaIkanSegarController::class)->only(['index', 'show']);

// Delete routes (admin/super admin only)
Route::middleware('is.admin')->group(function () {
    Route::resource('pembudidaya', \App\Http\Controllers\PembudidayaController::class)->only(['destroy']);
    Route::resource('pengolah', \App\Http\Controllers\PengolahController::class)->only(['destroy']);
    Route::resource('pemasar', \App\Http\Controllers\PemasarController::class)->only(['destroy']);
    Route::resource('harga-ikan-segar', \App\Http\Controllers\HargaIkanSegarController::class)->only(['destroy']);
});

// Peta lokasi route
Route::get('/peta-lokasi', [\App\Http\Controllers\PetaLokasiController::class, 'index'])->name('peta-lokasi.index');
