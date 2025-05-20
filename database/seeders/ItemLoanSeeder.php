<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemLoan;
use App\Models\User;
use App\Models\Item;
use Carbon\Carbon;

class ItemLoanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $items = Item::pluck('id')->toArray();
        $statuses = ['menunggu_konfirmasi_kembali','pending', 'kembali', 'pinjam'];

        for ($i = 0; $i < 20; $i++) {
            $status = fake()->randomElement($statuses);
            $tanggalPinjam = Carbon::now()->subDays(rand(1, 30));
            $tanggalKembali = $status === 'kembali' ? (clone $tanggalPinjam)->addDays(rand(1, 7)) : null;

            ItemLoan::create([
                'user_id' => fake()->randomElement($users),
                'item_id' => fake()->randomElement($items),
                'jumlah' => fake()->numberBetween(1, 5),
                'status' => $status,
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
