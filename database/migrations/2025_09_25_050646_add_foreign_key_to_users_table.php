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
    Schema::table('users', function (Blueprint $table) {
        // Membuat relasi dari kolom id_role ke kolom id_role di tabel roles
        $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Menghapus relasi jika di-rollback
        $table->dropForeign(['id_role']);
    });
}
};
