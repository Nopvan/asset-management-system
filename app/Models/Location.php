<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $table = 'locations';

    protected $fillable = ['name', 'address', 'luas'];

    public function rooms()
    {
        return $this->hasMany(Item::class, 'location_id');
    }
}
