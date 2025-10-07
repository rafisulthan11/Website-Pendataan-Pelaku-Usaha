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
    Schema::create('histori_saranas', function (Blueprint $table) {
        $table->id('id_sarana');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->integer('bulan');
        $table->year('tahun');
        $table->string('nama_sarana');
        $table->integer('jumlah');
        $table->string('kondisi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_saranas');
    }
};
