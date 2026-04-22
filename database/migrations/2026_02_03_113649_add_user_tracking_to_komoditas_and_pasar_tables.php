<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        Schema::table('komoditas', function (Blueprint $table) {
            if (!Schema::hasColumn('komoditas', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('komoditas', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('komoditas', function (Blueprint $table) {
                $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
            });
        }

        Schema::table('pasar', function (Blueprint $table) {
            if (!Schema::hasColumn('pasar', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pasar', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('pasar', function (Blueprint $table) {
                $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver !== 'sqlite') {
            Schema::table('komoditas', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });

            Schema::table('pasar', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
        }

        Schema::table('komoditas', function (Blueprint $table) {
            if (Schema::hasColumn('komoditas', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('komoditas', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });

        Schema::table('pasar', function (Blueprint $table) {
            if (Schema::hasColumn('pasar', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('pasar', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });
    }
};
