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
        Schema::table('pengolahs', function (Blueprint $table) {
            $table->string('nib')->nullable()->after('npwp_usaha');
            $table->string('kusuka')->nullable()->after('nib');
            $table->string('pengesahan_menkumham')->nullable()->after('kusuka');
            $table->string('tdu_php')->nullable()->after('pengesahan_menkumham');
            $table->string('akta_pendirian_usaha')->nullable()->after('tdu_php');
            $table->string('imb')->nullable()->after('akta_pendirian_usaha');
            $table->string('siup_perikanan')->nullable()->after('imb');
            $table->string('siup_perdagangan')->nullable()->after('siup_perikanan');
            $table->string('sppl')->nullable()->after('siup_perdagangan');
            $table->string('ukl_upl')->nullable()->after('sppl');
            $table->string('amdal')->nullable()->after('ukl_upl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengolahs', function (Blueprint $table) {
            $table->dropColumn([
                'nib',
                'kusuka',
                'pengesahan_menkumham',
                'tdu_php',
                'akta_pendirian_usaha',
                'imb',
                'siup_perikanan',
                'siup_perdagangan',
                'sppl',
                'ukl_upl',
                'amdal',
            ]);
        });
    }
};
