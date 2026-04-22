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
        $superAdminRole = Role::firstOrCreate(['nama_role' => 'super admin']);
        $adminRole = Role::firstOrCreate(['nama_role' => 'admin']);

        User::updateOrCreate(
            ['email' => 'superadmin@sincan.com'],
            [
                'nama_lengkap' => 'Super Admin SINCAN',
                'nip' => '111111111111111111',
                'password' => Hash::make('password'),
                'id_role' => $superAdminRole->id_role,
                'status' => 'aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@sincan.com'],
            [
                'nama_lengkap' => 'Admin SINCAN',
                'nip' => '222222222222222222',
                'password' => Hash::make('password'),
                'id_role' => $adminRole->id_role,
                'status' => 'aktif',
            ]
        );
    }
}