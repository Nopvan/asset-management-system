<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class RoomController extends Controller
{
    //


    public function byLocation($id)
    {
    $location = Location::with('rooms')->findOrFail($id);
    $rooms = $location->rooms;

    return view('pages.rooms.by-location', compact('location', 'rooms'));
}
}
