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
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
