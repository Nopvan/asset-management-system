<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $table = 'locations';

    protected $fillable = ['name', 'address', 'area', 'photo'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'location_id');
    }
}
