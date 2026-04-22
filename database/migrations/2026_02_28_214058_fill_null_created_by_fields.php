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
        // Update pembudidayas table - set created_by to updated_by if null
        DB::table('pembudidayas')
            ->whereNull('created_by')
            ->whereNotNull('updated_by')
            ->update(['created_by' => DB::raw('updated_by')]);
        
        // If still null, set to verified_by
        DB::table('pembudidayas')
            ->whereNull('created_by')
            ->whereNotNull('verified_by')
            ->update(['created_by' => DB::raw('verified_by')]);
        
        // Update pengolahs table
        DB::table('pengolahs')
            ->whereNull('created_by')
            ->whereNotNull('updated_by')
            ->update(['created_by' => DB::raw('updated_by')]);
        
        DB::table('pengolahs')
            ->whereNull('created_by')
            ->whereNotNull('verified_by')
            ->update(['created_by' => DB::raw('verified_by')]);
        
        // Update pemasars table
        DB::table('pemasars')
            ->whereNull('created_by')
            ->whereNotNull('updated_by')
            ->update(['created_by' => DB::raw('updated_by')]);
        
        DB::table('pemasars')
            ->whereNull('created_by')
            ->whereNotNull('verified_by')
            ->update(['created_by' => DB::raw('verified_by')]);
        
        // Update harga_ikan_segars table
        DB::table('harga_ikan_segars')
            ->whereNull('created_by')
            ->whereNotNull('updated_by')
            ->update(['created_by' => DB::raw('updated_by')]);
        
        DB::table('harga_ikan_segars')
            ->whereNull('created_by')
            ->whereNotNull('verified_by')
            ->update(['created_by' => DB::raw('verified_by')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this data migration
    }
};
