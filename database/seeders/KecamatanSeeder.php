<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_kecamatans')->insert([
            ['nama_kecamatan' => 'Sumberjambe'],
            ['nama_kecamatan' => 'Silo'],
            ['nama_kecamatan' => 'Ledokombo'],
            ['nama_kecamatan' => 'Sumbersari'],
            ['nama_kecamatan' => 'Patrang'],
        ]);
    }
}