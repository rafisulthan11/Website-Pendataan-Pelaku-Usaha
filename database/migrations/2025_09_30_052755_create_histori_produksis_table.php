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
    Schema::create('histori_produksis', function (Blueprint $table) {
        $table->id('id_produksi');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->integer('bulan');
        $table->year('tahun');
        $table->string('komoditas');
        $table->float('jumlah_produksi_kg');
        $table->float('nilai_jual_rp')->nullable();
        $table->string('tujuan_pemasaran')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_produksis');
    }
};
