<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomLoan;
use App\Models\ItemLoan;
use App\Models\Room;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;

class RoomLoanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $rooms = Room::pluck('id')->toArray();
        $statuses = ['menunggu_konfirmasi_kembali','pending', 'pinjam', 'kembali'];

        for ($i = 0; $i < 10; $i++) {
            $status = fake()->randomElement($statuses);
            $tanggalPinjam = Carbon::now()->subDays(rand(1, 30));
            $tanggalKembali = $status === 'kembali' ? (clone $tanggalPinjam)->addDays(rand(1, 7)) : null;

            // 1. Buat Room Loan
            $roomLoan = RoomLoan::create([
                'user_id' => fake()->randomElement($users),
                'room_id' => fake()->randomElement($rooms),
                'status' => $status,
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Ambil item dari ruangan tersebut
            $itemsInRoom = Item::where('room_id', $roomLoan->room_id)->get();

            foreach ($itemsInRoom as $item) {
                ItemLoan::create([
                    'user_id' => $roomLoan->user_id,
                    'item_id' => $item->id,
                    'room_loan_id' => $roomLoan->id,
                    'jumlah' => fake()->numberBetween(1, min(5, $item->qty)),
                    'status' => $status,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_kembali' => $tanggalKembali,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
