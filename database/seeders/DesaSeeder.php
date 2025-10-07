<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Kecamatan
        $sumberjambe = DB::table('master_kecamatans')->where('nama_kecamatan', 'Sumberjambe')->first();
        $sumbersari = DB::table('master_kecamatans')->where('nama_kecamatan', 'Sumbersari')->first();

        // Masukkan data desa
        DB::table('master_desas')->insert([
            ['id_kecamatan' => $sumberjambe->id_kecamatan, 'nama_desa' => 'Rowosari'],
            ['id_kecamatan' => $sumberjambe->id_kecamatan, 'nama_desa' => 'Sumberjambe'],
            ['id_kecamatan' => $sumberjambe->id_kecamatan, 'nama_desa' => 'Plerean'],

            ['id_kecamatan' => $sumbersari->id_kecamatan, 'nama_desa' => 'Karangrejo'],
            ['id_kecamatan' => $sumbersari->id_kecamatan, 'nama_desa' => 'Kebonsari'],
            ['id_kecamatan' => $sumbersari->id_kecamatan, 'nama_desa' => 'Tegalgede'],
        ]);
    }
}