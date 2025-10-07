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
    Schema::create('histori_bantuans', function (Blueprint $table) {
        $table->id('id_bantuan');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->year('tahun_diterima');
        $table->string('sumber_bantuan');
        $table->string('jenis_bantuan');
        $table->float('jumlah');
        $table->string('satuan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_bantuans');
    }
};
