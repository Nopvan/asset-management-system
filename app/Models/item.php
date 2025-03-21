<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = ['cat_id', 'item_name', 'conditions', 'qty', 'locations'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}
