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
        Schema::table('pembudidayas', function (Blueprint $table) {
        $table->string('jenis_kelamin')->nullable()->after('nama_lengkap');
        $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
        $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembudidayas', function (Blueprint $table) {
            //
        });
    }
};
