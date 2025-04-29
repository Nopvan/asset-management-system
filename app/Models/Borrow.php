<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = ['item_id', 'jumlah', 'status'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
