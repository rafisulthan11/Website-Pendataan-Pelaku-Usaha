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
    Schema::create('pembudidaya_tenaga_kerjas', function (Blueprint $table) {
        $table->id('id_tk');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->integer('jumlah_tetap')->default(0);
        $table->integer('jumlah_tidak_tetap')->default(0);
        $table->integer('keluarga_wni')->default(0);
        $table->integer('keluarga_wna')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_tenaga_kerjas');
    }
};
