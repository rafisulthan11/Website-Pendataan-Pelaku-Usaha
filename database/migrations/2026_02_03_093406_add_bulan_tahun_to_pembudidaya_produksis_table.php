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
        Schema::table('pembudidaya_produksis', function (Blueprint $table) {
            $table->string('bulan', 20)->nullable()->after('product_index');
            $table->year('tahun')->nullable()->after('bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembudidaya_produksis', function (Blueprint $table) {
            $table->dropColumn(['bulan', 'tahun']);
        });
    }
};
