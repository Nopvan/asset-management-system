<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['cat_name', 'cat_code'];

    public function items()
    {
        return $this->hasMany(Item::class, 'cat_id');
    }
}
