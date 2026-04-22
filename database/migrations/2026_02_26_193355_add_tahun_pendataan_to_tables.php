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
        // Add tahun_pendataan to pembudidayas table
        Schema::table('pembudidayas', function (Blueprint $table) {
            $table->year('tahun_pendataan')->default(date('Y'))->after('id_pembudidaya');
            $table->index('tahun_pendataan');
        });

        // Add tahun_pendataan to pengolahs table
        Schema::table('pengolahs', function (Blueprint $table) {
            $table->year('tahun_pendataan')->default(date('Y'))->after('id_pengolah');
            $table->index('tahun_pendataan');
        });

        // Add tahun_pendataan to pemasars table
        Schema::table('pemasars', function (Blueprint $table) {
            $table->year('tahun_pendataan')->default(date('Y'))->after('id_pemasar');
            $table->index('tahun_pendataan');
        });

        // Add tahun_pendataan to harga_ikan_segars table
        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            $table->year('tahun_pendataan')->default(date('Y'))->after('id_harga');
            $table->index('tahun_pendataan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembudidayas', function (Blueprint $table) {
            $table->dropIndex(['tahun_pendataan']);
            $table->dropColumn('tahun_pendataan');
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            $table->dropIndex(['tahun_pendataan']);
            $table->dropColumn('tahun_pendataan');
        });

        Schema::table('pemasars', function (Blueprint $table) {
            $table->dropIndex(['tahun_pendataan']);
            $table->dropColumn('tahun_pendataan');
        });

        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            $table->dropIndex(['tahun_pendataan']);
            $table->dropColumn('tahun_pendataan');
        });
    }
};
