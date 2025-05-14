<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('rooms.items')->paginate(10);
        return view('pages.locations.index', compact('locations'));
    }

    public function show($id)
    {
        $location = Location::with('rooms.items')->findOrFail($id);
        return view('pages.locations.show', compact('location'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'resepsionis'])) {
        abort(403, 'Unauthorized');
        }
        return view('pages.locations.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'area' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
        $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('storage/uploads/locations'), $filename);
        $path = 'uploads/locations/' . $filename;
    }

        Location::create([
            'name' => $request->name,
            'address' => $request->address,
            'area' => $request->area,
            'photo' => $path ?? null, 
        ]);

        return redirect('/locations')->with('success', 'Location has been added');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('pages.locations.edit', compact('location'));
    }
    
    public function exportPdf()
{
    // Ambil semua data lokasi
    $locations = Location::withCount('rooms')->get()->chunk(10);

    // Kirim ke view PDF
    $pdf = Pdf::loadView('pages.locations.pdf', [
        'locations' => $locations
    ]);

    // Unduh PDF
    return $pdf->download('locations.pdf');
}
}
