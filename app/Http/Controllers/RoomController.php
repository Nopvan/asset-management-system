<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('location')->paginate(10);
        return view('pages.rooms.index', compact('rooms'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'resepsionis'])) {
            abort(403, 'Unauthorized');
        }

        $locations = Location::all();
        return view('pages.rooms.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'area' => 'required|numeric',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('storage/uploads/rooms'), $filename);
            $validated['photo'] = 'uploads/rooms/' . $filename;
        }

        Room::create($validated);
        return redirect('/rooms')->with('success', 'Room added successfully');
    }

    public function show($id)
    {
        $room = Room::with(['location', 'items'])->findOrFail($id);
        return view('pages.rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $locations = Location::all();
        return view('pages.rooms.edit', compact('room', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'area' => 'required|numeric',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('storage/uploads/rooms'), $filename);
            $validated['photo'] = 'uploads/rooms/' . $filename;
        }

        $room->update($validated);
        return redirect('/rooms')->with('success', 'Room updated successfully');
    }

    public function exportPdf()
    {
        $rooms = Room::with('location')->get()->chunk(24);

        $pdf = Pdf::loadView('pages.rooms.pdf', compact('rooms'));
        return $pdf->download('rooms.pdf');
    }

    public function byLocation($id)
    {
    $location = Location::with('rooms')->findOrFail($id);
    $rooms = $location->rooms;

    return view('pages.rooms.by-location', compact('location', 'rooms'));
}
}
