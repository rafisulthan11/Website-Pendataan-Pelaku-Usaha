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
    Schema::create('pembudidaya_kolams', function (Blueprint $table) {
        $table->id('id_kolam');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->string('jenis_kolam');
        $table->string('ukuran')->nullable();
        $table->integer('jumlah');
        $table->string('komoditas')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_kolams');
    }
};
