<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_loan_id',
        'item_id',
        'jumlah',
        'jumlah_kembali',
        'jumlah_hilang',
        'jumlah_rusak',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keterangan',
        'photo_diterima',
        'photo_dikembalikan',
    ];

    // Relasi ke item yang dipinjam
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke peminjaman ruangan (jika peminjaman item berasal dari peminjaman ruangan)
    public function roomLoan()
    {
        return $this->belongsTo(RoomLoan::class);
    }

    // Relasi ke user yang minjem (optional kalau sudah ada di roomLoan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(RoomLoan::class, 'room_loan_id');
    }

}
