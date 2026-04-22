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
        Schema::table('pemasars', function (Blueprint $table) {
            // Production Fields
            $table->decimal('biaya_produksi', 15, 2)->nullable()->after('distribusi_pemasaran');
            $table->decimal('harga_jual_produksi', 15, 2)->nullable();
            $table->decimal('kapasitas_terpasang', 12, 2)->nullable();
            $table->decimal('hasil_produksi_kg', 12, 2)->nullable();
            $table->decimal('hasil_produksi_rp', 15, 2)->nullable();
            
            // Marketing/Distribution Data (store as JSON array)
            $table->json('data_pemasaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasars', function (Blueprint $table) {
            $table->dropColumn([
                'biaya_produksi',
                'harga_jual_produksi',
                'kapasitas_terpasang',
                'hasil_produksi_kg',
                'hasil_produksi_rp',
                'data_pemasaran',
            ]);
        });
    }
};
