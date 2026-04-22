<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel untuk backup data pembudidaya yang sudah verified sebelum diedit
        Schema::create('pembudidaya_verified_backup', function (Blueprint $table) {
            $table->id('id_backup');
            $table->unsignedBigInteger('id_pembudidaya')->unique(); // ID data asli
            $table->json('data_verified'); // Snapshot data verified sebelum diedit
            $table->timestamp('backed_up_at');
            $table->index('id_pembudidaya');
        });

        // Tabel untuk backup data pengolah yang sudah verified sebelum diedit
        Schema::create('pengolah_verified_backup', function (Blueprint $table) {
            $table->id('id_backup');
            $table->unsignedBigInteger('id_pengolah')->unique();
            $table->json('data_verified');
            $table->timestamp('backed_up_at');
            $table->index('id_pengolah');
        });

        // Tabel untuk backup data pemasar yang sudah verified sebelum diedit
        Schema::create('pemasar_verified_backup', function (Blueprint $table) {
            $table->id('id_backup');
            $table->unsignedBigInteger('id_pemasar')->unique();
            $table->json('data_verified');
            $table->timestamp('backed_up_at');
            $table->index('id_pemasar');
        });

        // Tabel untuk backup data harga ikan yang sudah verified sebelum diedit
        Schema::create('harga_ikan_segar_verified_backup', function (Blueprint $table) {
            $table->id('id_backup');
            $table->unsignedBigInteger('id_harga')->unique();
            $table->json('data_verified');
            $table->timestamp('backed_up_at');
            $table->index('id_harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_verified_backup');
        Schema::dropIfExists('pengolah_verified_backup');
        Schema::dropIfExists('pemasar_verified_backup');
        Schema::dropIfExists('harga_ikan_segar_verified_backup');
    }
};
