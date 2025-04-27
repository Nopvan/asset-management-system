<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori yang memiliki item dengan qty > 0 dan kondisi good
        $kategori = Category::whereHas('items', function($query) {
            $query->where('qty', '>', 0)
                  ->whereNotIn('conditions', ['lost', 'broken']);
        }, '=', 1, 'and', function($query) {
            $query->whereColumn('categories.id', 'items.cat_id'); // Perhatikan relasi disini
        })->get();
    
        // Ambil lokasi yang memiliki item dengan qty > 0 dan kondisi good
        $lokasi = Item::select('locations')
                    ->where('qty', '>', 0)
                    ->whereNotIn('conditions', ['lost', 'broken'])
                    ->whereNotNull('locations')
                    ->distinct()
                    ->pluck('locations');
    
        $query = Item::with('category')
                  ->where('qty', '>', 0)
                  ->whereNotIn('conditions', ['lost', 'broken']);
    
        // Filter pencarian
        if ($request->filled('nama')) {
            $query->where('item_name', 'like', '%' . $request->nama . '%');
        }
    
        if ($request->filled('kategori_id')) {
            $query->where('cat_id', $request->kategori_id); // Pastikan ini sesuai dengan kolom di tabel
        }
    
        if ($request->filled('lokasi')) {
            $query->where('locations', 'like', '%' . $request->lokasi . '%');
        }
    
        // Khusus pertama kali (tanpa filter), order qty terbanyak
        if (!$request->filled('nama') && !$request->filled('kategori_id') && !$request->filled('lokasi')) {
            $query->orderBy('qty', 'desc');
        }
    
        $items = $query->paginate(10)->withQueryString();
    
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
