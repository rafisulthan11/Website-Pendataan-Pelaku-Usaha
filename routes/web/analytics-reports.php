<?php

use Illuminate\Support\Facades\Route;

// Grafik (admin dan super admin)
Route::middleware('is.admin')->group(function () {
    Route::get('/grafik/pelaku-usaha', [\App\Http\Controllers\GrafikController::class, 'pelakuUsaha'])->name('grafik.pelaku.usaha');
    Route::get('/grafik/harga-ikan-segar', [\App\Http\Controllers\GrafikController::class, 'hargaIkanSegar'])->name('grafik.harga.ikan.segar');
    Route::get('/grafik/produksi-ikan', [\App\Http\Controllers\GrafikController::class, 'produksiIkan'])->name('grafik.produksi.ikan');
});

// Laporan (admin dan super admin)
Route::middleware('is.admin')->group(function () {
    Route::get('/laporan/rekapitulasi/pembudidaya', [\App\Http\Controllers\LaporanController::class, 'rekapitulasiPembudidaya'])
        ->name('laporan.rekapitulasi.pembudidaya');
    Route::get('/laporan/rekapitulasi/pembudidaya/export', [\App\Http\Controllers\LaporanController::class, 'exportPembudidaya'])
        ->name('laporan.rekapitulasi.pembudidaya.export');
    Route::get('/laporan/rekapitulasi/pembudidaya/pdf/{id}', [\App\Http\Controllers\LaporanController::class, 'pdfPembudidaya'])
        ->name('laporan.rekapitulasi.pembudidaya.pdf');

    Route::get('/laporan/rekapitulasi/pengolah', [\App\Http\Controllers\LaporanController::class, 'rekapitulasiPengolah'])
        ->name('laporan.rekapitulasi.pengolah');
    Route::get('/laporan/rekapitulasi/pengolah/export', [\App\Http\Controllers\LaporanController::class, 'exportPengolah'])
        ->name('laporan.rekapitulasi.pengolah.export');
    Route::get('/laporan/rekapitulasi/pengolah/pdf/{id}', [\App\Http\Controllers\LaporanController::class, 'pdfPengolah'])
        ->name('laporan.rekapitulasi.pengolah.pdf');

    Route::get('/laporan/rekapitulasi/pemasar', [\App\Http\Controllers\LaporanController::class, 'rekapitulasiPemasar'])
        ->name('laporan.rekapitulasi.pemasar');
    Route::get('/laporan/rekapitulasi/pemasar/export', [\App\Http\Controllers\LaporanController::class, 'exportPemasar'])
        ->name('laporan.rekapitulasi.pemasar.export');
    Route::get('/laporan/rekapitulasi/pemasar/pdf/{id}', [\App\Http\Controllers\LaporanController::class, 'pdfPemasar'])
        ->name('laporan.rekapitulasi.pemasar.pdf');

    Route::get('/laporan/harga-ikan-segar', [\App\Http\Controllers\LaporanController::class, 'rekapHargaIkanSegar'])
        ->name('laporan.harga.ikan.segar');
    Route::get('/laporan/harga-ikan-segar/export', [\App\Http\Controllers\LaporanController::class, 'exportHargaIkanSegar'])
        ->name('laporan.harga.ikan.segar.export');
    Route::get('/laporan/harga-ikan-segar/pdf/{id}', [\App\Http\Controllers\LaporanController::class, 'pdfHargaIkanSegar'])
        ->name('laporan.harga.ikan.segar.pdf');
});
