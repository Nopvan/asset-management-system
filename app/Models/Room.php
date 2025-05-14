<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = ['name','location_id', 'luas'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'room_id');
    }

}
