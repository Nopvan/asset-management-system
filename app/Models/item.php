<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = ['cat_id', 'room_id', 'item_name', 'conditions', 'qty' ,'photo'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
