<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\Location;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        $roomIds = Location::pluck('id')->toArray();

        $itemNames = [
            'Proyektor Epson', 'Laptop Lenovo', 'Mouse Logitech', 'Keyboard Mechanical',
            'Seragam Pramuka', 'Jas Lab', 'Sepatu Olahraga', 'Snack Ringan', 'Buku Biologi',
            'Alat Ukur Panjang', 'Kursi Lipat', 'Meja Guru', 'Whiteboard', 'Printer Canon',
            'Scanner Epson', 'Mikroskop', 'Tabung Reaksi', 'Lap Pembersih', 'Sapu Lidi',
            'Tempat Sampah', 'Pulpen Hitam', 'Pensil 2B', 'Penggaris Besi', 'Bola Basket',
            'Net Voli', 'Buku Sejarah', 'Laptop ASUS', 'Router WiFi', 'Kipas Angin', 'AC Portable'
        ];

        foreach ($itemNames as $name) {
            Item::create([
                'cat_id' => fake()->randomElement($categoryIds),
                'room_id' => fake()->randomElement($roomIds),
                'item_name' => $name,
                'conditions' => fake()->randomElement(['good', 'lost', 'broken']),
                'qty' => fake()->numberBetween(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
