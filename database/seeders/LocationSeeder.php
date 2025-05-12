<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 1; $i <= 10; $i++) {
            Location::create([
                'name' => 'Gedung ' . chr(64 + $i), // Gedung A, B, C, dst
                'address' => $faker->address,
                'luas' => $faker->numberBetween(100, 1000), // luas m2
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
