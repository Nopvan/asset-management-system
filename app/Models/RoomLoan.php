<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi ke user yang meminjam
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke ruangan yang dipinjam
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }


    // Relasi ke semua item yang otomatis dipinjam karena minjem ruangan
    public function itemLoans()
    {
        return $this->hasMany(ItemLoan::class);
    }
}
