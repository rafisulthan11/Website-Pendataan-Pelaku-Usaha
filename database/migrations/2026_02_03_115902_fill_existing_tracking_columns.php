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
        // Ambil user pertama sebagai default (biasanya admin/super admin)
        $defaultUserId = DB::table('users')->orderBy('id_user')->value('id_user');
        
        if ($defaultUserId) {
            // Update pembudidayas
            DB::table('pembudidayas')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
            
            // Update pengolahs
            DB::table('pengolahs')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
            
            // Update pemasars
            DB::table('pemasars')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
            
            // Update harga_ikan_segars
            DB::table('harga_ikan_segars')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
            
            // Update komoditas
            DB::table('komoditas')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
            
            // Update pasar
            DB::table('pasar')
                ->whereNull('created_by')
                ->orWhereNull('updated_by')
                ->update([
                    'created_by' => DB::raw("COALESCE(created_by, $defaultUserId)"),
                    'updated_by' => DB::raw("COALESCE(updated_by, $defaultUserId)")
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback karena ini hanya mengisi data
    }
};
