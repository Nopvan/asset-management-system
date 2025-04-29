<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'nama' => 'Super Admin',
                'username' => 'superadmin',
                'kelas' => 'XII RPL',
                'nomor_telpon' => '081234567890',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ],
            [
                'nama' => 'Resepsionis',
                'username' => 'resepsionis',
                'kelas' => 'XII MM',
                'nomor_telpon' => '081298765432',
                'email' => 'resepsionis@example.com',
                'password' => Hash::make('password'),
                'role' => 'resepsionis',
            ],
            [
                'nama' => 'Siswa Biasa',
                'username' => 'user123',
                'kelas' => 'XI TKJ',
                'nomor_telpon' => '082112345678',
                'email' => 'user123@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        ]);
    }
}

