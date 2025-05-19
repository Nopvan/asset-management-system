<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        'cat_id' => 'required|exists:categories,id',
        'item_name' => 'required|string',
        'conditions' => ['required', Rule::in(['good', 'lost', 'broken'])],
        'qty' => 'required|integer|min:0',
        'room_id' => 'required|exists:rooms,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $item = Item::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        $oldPath = public_path('storage/' . $item->photo);
        if ($item->photo && file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Move new photo
        $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('storage/uploads/items'), $filename);

        // Simpan path yang sama kayak saat create
        $validatedData['photo'] = 'uploads/items/' . $filename;
    }

    $item->update($validatedData);

    return redirect('/item')->with('success', 'Item has been updated');
}



  public function destroy($id)
    {
        $item = Item::findOrFail($id);
        // Hapus file foto jika ada
        if ($item->photo) {
            $photoPath = public_path('storage/' . $item->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        // Hapus item dari database
        $item->delete();

        return redirect('/item')->with('success', 'Item has been deleted');
    }


 public function exportPdf()
    {
        if (!in_array(Auth::user()->role, ['super_admin', 'resepsionis'])) {
            abort(403, 'Unauthorized');
        }
        // Ambil semua data item, termasuk kategori dan room, bagi per 10 item
        $items = Item::with(['category', 'room'])->get()->chunk(24);

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

        public function lostItems()
    {
        $items = Item::select(
                'items.*',
                DB::raw('SUM(item_loans.jumlah_hilang) as total_lost_from_loans'),
                DB::raw('CASE WHEN items.conditions = "lost" THEN items.qty ELSE 0 END as lost_from_items')
            )
            ->leftJoin('item_loans', 'items.id', '=', 'item_loans.item_id')
            ->groupBy('items.id')
            ->havingRaw('total_lost_from_loans > 0 OR items.conditions = "lost"')
            ->with(['category', 'room'])
            ->paginate(10);

        return view('pages.items.lost-items', compact('items'));
    }

    public function brokenItems()
    {
        $items = Item::select(
                'items.*',
                DB::raw('SUM(item_loans.jumlah_rusak) as total_broken_from_loans'),
                DB::raw('CASE WHEN items.conditions = "broken" THEN items.qty ELSE 0 END as broken_from_items')
            )
            ->leftJoin('item_loans', 'items.id', '=', 'item_loans.item_id')
            ->groupBy('items.id')
            ->havingRaw('total_broken_from_loans > 0 OR items.conditions = "broken"')
            ->with(['category', 'room'])
            ->paginate(10);

        return view('pages.items.broken-items', compact('items'));
    }



}
