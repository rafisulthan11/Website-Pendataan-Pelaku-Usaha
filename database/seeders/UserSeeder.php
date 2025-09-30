<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cari role 'admin'
        $adminRole = Role::where('nama_role', 'admin')->first();

        // Buat user admin default
        User::create([
            'nama_lengkap' => 'Admin SINCAN',   
            'email' => 'admin@sincan.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'id_role' => $adminRole->id_role,
            'status' => 'aktif',
        ]);
    }
}