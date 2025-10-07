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
    Schema::create('master_desas', function (Blueprint $table) {
        $table->id('id_desa');
        $table->foreignId('id_kecamatan')->constrained('master_kecamatans', 'id_kecamatan');
        $table->string('nama_desa');
        $table->string('kode_desa')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_desas');
    }
};
