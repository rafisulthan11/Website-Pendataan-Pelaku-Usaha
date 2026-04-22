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
        Schema::table('pembudidaya_kolams', function (Blueprint $table) {
            $table->integer('product_index')->default(0)->after('id_pembudidaya');
        });

        Schema::table('pembudidaya_ikans', function (Blueprint $table) {
            $table->integer('product_index')->default(0)->after('id_pembudidaya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembudidaya_kolams', function (Blueprint $table) {
            $table->dropColumn('product_index');
        });

        Schema::table('pembudidaya_ikans', function (Blueprint $table) {
            $table->dropColumn('product_index');
        });
    }
};
