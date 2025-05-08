<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Resepsionis',
                'username' => 'resepsionis',
                'kelas' => 'XII MM',
                'nomor_telpon' => '081298765432',
                'email' => 'resepsionis@example.com',
                'password' => Hash::make('password'),
                'role' => 'resepsionis',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Mydei',
                'username' => 'mydei123',
                'kelas' => 'XI TKJ',
                'nomor_telpon' => '082111111111',
                'email' => 'mydei123@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruan Mei',
                'username' => 'ruanmei123',
                'kelas' => 'XII RPL',
                'nomor_telpon' => '082122222222',
                'email' => 'ruanmei123@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Yanqing',
                'username' => 'yanqing123',
                'kelas' => 'X MM',
                'nomor_telpon' => '082133333333',
                'email' => 'yangqing123@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Moze',
                'username' => 'moze123',
                'kelas' => 'XI TKJ',
                'nomor_telpon' => '082144444444',
                'email' => 'moze123@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Luocha',
                'username' => 'luocha123',
                'kelas' => 'XII MM',
                'nomor_telpon' => '082155555555',
                'email' => 'luocha@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
