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
    Schema::create('pembudidaya_investasis', function (Blueprint $table) {
        $table->id('id_investasi');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->float('nilai_asset')->nullable();
        $table->float('modal_sendiri')->nullable();
        $table->float('sewa')->nullable();
        $table->string('lahan_sertifikat')->nullable();
        $table->float('luas_lahan')->nullable();
        $table->float('nilai_lahan')->nullable();
        $table->string('bangunan_sertifikat')->nullable();
        $table->float('luas_bangunan')->nullable();
        $table->float('nilai_bangunan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_investasis');
    }
};
