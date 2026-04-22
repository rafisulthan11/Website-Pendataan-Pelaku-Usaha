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
        // Update users yang belum punya NIP dengan NIP sementara
        $usersWithoutNip = DB::table('users')
            ->select('id_user')
            ->whereNull('nip')
            ->orWhere('nip', '')
            ->get();

        foreach ($usersWithoutNip as $user) {
            DB::table('users')
                ->where('id_user', $user->id_user)
                ->update([
                    'nip' => str_pad((string) $user->id_user, 18, '0', STR_PAD_LEFT),
                ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('nip', 18)->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nip']);
            $table->string('nip', 50)->nullable()->change();
        });
    }
};
