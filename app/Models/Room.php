<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = ['name','location_id', 'luas'];

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
