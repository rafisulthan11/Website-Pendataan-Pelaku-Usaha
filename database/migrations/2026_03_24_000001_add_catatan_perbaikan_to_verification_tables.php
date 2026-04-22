<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembudidayas', function (Blueprint $table) {
            if (!Schema::hasColumn('pembudidayas', 'catatan_perbaikan')) {
                $table->text('catatan_perbaikan')->nullable()->after('verified_at');
            }
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            if (!Schema::hasColumn('pengolahs', 'catatan_perbaikan')) {
                $table->text('catatan_perbaikan')->nullable()->after('verified_at');
            }
        });

        Schema::table('pemasars', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasars', 'catatan_perbaikan')) {
                $table->text('catatan_perbaikan')->nullable()->after('verified_at');
            }
        });

        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            if (!Schema::hasColumn('harga_ikan_segars', 'catatan_perbaikan')) {
                $table->text('catatan_perbaikan')->nullable()->after('verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembudidayas', function (Blueprint $table) {
            if (Schema::hasColumn('pembudidayas', 'catatan_perbaikan')) {
                $table->dropColumn('catatan_perbaikan');
            }
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            if (Schema::hasColumn('pengolahs', 'catatan_perbaikan')) {
                $table->dropColumn('catatan_perbaikan');
            }
        });

        Schema::table('pemasars', function (Blueprint $table) {
            if (Schema::hasColumn('pemasars', 'catatan_perbaikan')) {
                $table->dropColumn('catatan_perbaikan');
            }
        });

        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            if (Schema::hasColumn('harga_ikan_segars', 'catatan_perbaikan')) {
                $table->dropColumn('catatan_perbaikan');
            }
        });
    }
};
