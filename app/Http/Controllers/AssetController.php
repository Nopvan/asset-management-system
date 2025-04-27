<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Category::all();
        $lokasi = Item::select('locations')
                    ->distinct()
                    ->whereNotNull('locations')
                    ->pluck('locations');

        $query = Item::with('category');

        // Filter pencarian
        if ($request->filled('nama')) {
            $query->where('item_name', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('cat_id', $request->kategori_id);
        }

        if ($request->filled('lokasi')) {
            $query->where('locations', 'like', '%' . $request->lokasi . '%');
        }

        // Khusus pertama kali (tanpa filter), order qty terbanyak
        if (!$request->filled('nama') && !$request->filled('kategori_id') && !$request->filled('lokasi')) {
            $query->orderBy('qty', 'desc');
        }

        $items = $query->where('qty', '>', 0)
              ->whereNotIn('conditions', ['lost', 'broken'])
              ->paginate(10)
              ->withQueryString();

        return view('assets.index', compact('items', 'kategori', 'lokasi'));
    }
    

    public function pinjam(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        // Contoh pengecekan kondisi sebelum pinjam
        if ($item->qty <= 0) {
            return back()->with('error', 'Asset tidak tersedia untuk dipinjam.');
        }

        // Update quantity (kurangi 1)
        $item->qty -= 1;
        $item->save();

        return back()->with('success', 'Asset berhasil dipinjam.');
    }
}
