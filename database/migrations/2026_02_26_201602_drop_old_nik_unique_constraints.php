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
        // Drop old single-column unique constraints on NIK fields
        // These are replaced by composite unique constraints (NIK + tahun_pendataan)
        
        Schema::table('pembudidayas', function (Blueprint $table) {
            $table->dropUnique('pembudidayas_nik_pembudidaya_unique');
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            $table->dropUnique('pengolahs_nik_pengolah_unique');
        });

        Schema::table('pemasars', function (Blueprint $table) {
            $table->dropUnique('pemasars_nik_pemasar_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore old single-column unique constraints
        Schema::table('pembudidayas', function (Blueprint $table) {
            $table->string('nik_pembudidaya')->unique()->change();
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            $table->string('nik_pengolah')->unique()->change();
        });

        Schema::table('pemasars', function (Blueprint $table) {
            $table->string('nik_pemasar')->unique()->change();
        });
    }
};
