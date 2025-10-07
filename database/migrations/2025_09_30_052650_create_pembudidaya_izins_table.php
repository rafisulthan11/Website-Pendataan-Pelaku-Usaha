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
    Schema::create('pembudidaya_izins', function (Blueprint $table) {
        $table->id('id_izin');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->string('jenis_izin');
        $table->string('nomor_izin')->nullable();
        $table->date('tanggal_terbit')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_izins');
    }
};
