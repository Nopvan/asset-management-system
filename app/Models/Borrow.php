<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'jumlah',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',    
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
