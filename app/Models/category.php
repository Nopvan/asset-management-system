<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $category = 'categories';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
