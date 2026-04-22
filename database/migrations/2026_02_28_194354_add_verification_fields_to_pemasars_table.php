<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        Schema::table('pemasars', function (Blueprint $table) {
            if (!Schema::hasColumn('pemasars', 'status')) {
                $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending')->after('tahun_pendataan');
            }
            if (!Schema::hasColumn('pemasars', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pemasars', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });

        if ($driver !== 'sqlite') {
            Schema::table('pemasars', function (Blueprint $table) {
                $table->foreign('verified_by')->references('id_user')->on('users')->onDelete('set null');
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
            Schema::table('pemasars', function (Blueprint $table) {
                $table->dropForeign(['verified_by']);
            });
        }

        Schema::table('pemasars', function (Blueprint $table) {
            if (Schema::hasColumn('pemasars', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('pemasars', 'verified_by')) {
                $table->dropColumn('verified_by');
            }
            if (Schema::hasColumn('pemasars', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }
};
