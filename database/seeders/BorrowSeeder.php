<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Item;

class BorrowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $items = Item::pluck('id')->toArray();

        $statuses = ['pending', 'kembali', 'pinjam'];

        // Generate 20 peminjaman acak
        for ($i = 0; $i < 20; $i++) {
            Borrow::create([
                'user_id' => fake()->randomElement($users),
                'item_id' => fake()->randomElement($items),
                'jumlah' => fake()->numberBetween(1, 5),
                'status' => fake()->randomElement($statuses),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
