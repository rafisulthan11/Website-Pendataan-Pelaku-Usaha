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
    Schema::create('pembudidaya_lampirans', function (Blueprint $table) {
        $table->id('id_lampiran');
        $table->foreignId('id_pembudidaya')->constrained('pembudidayas', 'id_pembudidaya')->onDelete('cascade');
        $table->string('jenis_lampiran'); // Isinya: 'FOTO_KTP', 'FOTO_USAHA', dll.
        $table->string('path_file');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya_lampirans');
    }
};
