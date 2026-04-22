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

        // Add created_by and updated_by to pembudidayas
        Schema::table('pembudidayas', function (Blueprint $table) {
            if (!Schema::hasColumn('pembudidayas', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('pembudidayas', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('pembudidayas', function (Blueprint $table) {
                $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
            });
        }

        // Add created_by and updated_by to pengolahs
        Schema::table('pengolahs', function (Blueprint $table) {
            if (!Schema::hasColumn('pengolahs', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('pengolahs', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('pengolahs', function (Blueprint $table) {
                $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
            });
        }

        // Add created_by and updated_by to pemasars
        Schema::table('pemasars', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasars', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('pemasars', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('pemasars', function (Blueprint $table) {
                $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
            });
        }

        // Add created_by and updated_by to harga_ikan_segars
        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            if (!Schema::hasColumn('harga_ikan_segars', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('harga_ikan_segars', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('harga_ikan_segars', function (Blueprint $table) {
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
            Schema::table('pembudidayas', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
            Schema::table('pengolahs', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
            Schema::table('pemasars', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
            Schema::table('harga_ikan_segars', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
        }

        Schema::table('pembudidayas', function (Blueprint $table) {
            if (Schema::hasColumn('pembudidayas', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('pembudidayas', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });

        Schema::table('pengolahs', function (Blueprint $table) {
            if (Schema::hasColumn('pengolahs', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('pengolahs', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });

        Schema::table('pemasars', function (Blueprint $table) {
            if (Schema::hasColumn('pemasars', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('pemasars', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });

        Schema::table('harga_ikan_segars', function (Blueprint $table) {
            if (Schema::hasColumn('harga_ikan_segars', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('harga_ikan_segars', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
        });
    }
};
