<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->paginate(10);
        return view('pages.items.index',
            [
                'items' => $items
            ]);
    }

    public function create()
    {
        $categories = category::all(); // Ambil semua kategori
        $rooms = Room::all(); // Ambil semua room
        return view('pages.items.create', compact('categories', 'rooms'));
    }


public function store(Request $request)
{
    $validatedData = $request->validate([
        'cat_id' => 'required|exists:categories,id',
        'item_name' => 'required|string|max:255',
        'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
        'qty' => 'required|integer|min:0',
        'room_id' => 'required|exists:rooms,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $path = null;
    if ($request->hasFile('photo')) {
        $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('storage/uploads/items'), $filename);
        $path = 'uploads/items/' . $filename;
    }

    Item::create([
        'cat_id' => $validatedData['cat_id'],
        'item_name' => $validatedData['item_name'],
        'conditions' => $validatedData['conditions'],
        'qty' => $validatedData['qty'],
        'room_id' => $validatedData['room_id'],
        'photo' => $path,
    ]);

    return redirect('/item')->with('success', 'Item has been added');
}

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori
        $rooms = Room::all(); // Ambil semua room
        return view('pages.items.edit', compact('item', 'categories', 'rooms'));
    }
    
    public function show($id)
    {
        $item = Item::findOrFail($id);
        
        return view('pages.items.show', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cat_id' => 'required',
            'item_name' => 'required',
            'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
            'qty' => 'required',
            'locations' => 'required',
        ]);

        Item::findOrFail($id)->update($validatedData);
        return redirect('/item')->with('success', 'Item has been updated');
    }

    public function destroy($id)
    {
        $items = Item::find($id);
        $items->delete();

        return redirect('/item')->with('success', 'Item has been deleted');
    }

 public function exportPdf()
{
    if (!in_array(Auth::user()->role, ['super_admin', 'resepsionis'])) {
        abort(403, 'Unauthorized');
    }
    // Ambil semua data item, termasuk kategori dan room, bagi per 10 item
    $items = Item::with(['category', 'room'])->get()->chunk(10);

    // Kirim ke view PDF yang sudah disiapkan
    $pdf = Pdf::loadView('pages.items.pdf', [
        'items' => $items
    ]);

    // Download hasil PDF-nya
    return $pdf->download('items.pdf');
}

//Untuk menampilkan item via room
public function byRoom($roomId)
{
    $room = Room::with(['items.category', 'location'])->findOrFail($roomId);
    $items = $room->items()->paginate(10);
    $location = $room->location;

    return view('pages.items.by-room', compact('room', 'items', 'location'));
}


}
