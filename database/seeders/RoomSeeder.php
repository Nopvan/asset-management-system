<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Location;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $locationIds = Location::pluck('id')->toArray();
        $roomNames = [
            'Ruang Kelas 1', 'Ruang Kelas 2', 'Ruang Kelas 3', 'Lab Komputer',
            'Lab IPA', 'Perpustakaan', 'Ruang Guru', 'Ruang Kepala Sekolah',
            'Ruang TU', 'Gudang', 'Aula', 'Ruang BK', 'UKS', 'Mushola'
        ];

        foreach ($roomNames as $name) {
            Room::create([
                'location_id' => $faker->randomElement($locationIds),
                'name' => $name,
                'luas' => $faker->numberBetween(20, 150),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
