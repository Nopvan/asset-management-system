<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['cat_name' => 'Elektronik', 'cat_code' => 'ELEK'],
            ['cat_name' => 'Pakaian', 'cat_code' => 'PAKA'],
            ['cat_name' => 'Makanan', 'cat_code' => 'MAKA'],
            ['cat_name' => 'Alat Tulis', 'cat_code' => 'ATK'],
            ['cat_name' => 'Peralatan Olahraga', 'cat_code' => 'SPORT'],
            ['cat_name' => 'Perpustakaan', 'cat_code' => 'BOOK'],
            ['cat_name' => 'Kebersihan', 'cat_code' => 'CLN'],
            ['cat_name' => 'Lab IPA', 'cat_code' => 'IPA'],
            ['cat_name' => 'Lab Komputer', 'cat_code' => 'LAB'],
            ['cat_name' => 'Furniture', 'cat_code' => 'FURN'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                ...$cat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
