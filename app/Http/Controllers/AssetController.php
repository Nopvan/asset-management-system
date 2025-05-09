<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Borrow;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
//     public function __construct()
// {
//     $this->middleware('auth')->except(['index']);
// }

    public function index(Request $request)
    {
        // Ambil kategori yang memiliki item dengan qty > 0 dan kondisi good
        $kategori = Category::whereHas('items', function($query) {
            $query->where('qty', '>', 0)
                  ->whereNotIn('conditions', ['lost', 'broken']);
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
            $query->where('cat_id', $request->kategori_id); 
        }
    
        if ($request->filled('lokasi')) {
            $query->where('locations', 'like', '%' . $request->lokasi . '%');
        }
    
        // Khusus pertama kali (tanpa filter), order qty terbanyak
        if (!$request->filled('nama') && !$request->filled('kategori_id') && !$request->filled('lokasi')) {
            $query->orderBy('qty', 'desc');
        }
    
        $items = $query->paginate(9)->withQueryString();
    
        return view('assets.index', compact('items', 'kategori', 'lokasi'));
    }
    

    public function showPinjamForm($id)
    {
        $item = Item::findOrFail($id);
        return view('assets.form_pinjam', compact('item'));
    }

    public function pinjam(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $item->qty,
        ]);
    
        // Kurangi stok
        $item->qty -= $request->jumlah;
        $item->save();
    
        // Simpan ke riwayat peminjaman
        Borrow::create([
            'user_id'   => Auth::id(),
            'item_id'   => $item->id,
            'jumlah'    => $request->jumlah,
            'status'    => 'pinjam',
            'tanggal_pinjam' => now(),
        ]);
    
        return redirect()->route('assets.borrow.index')->with('success', 'Asset berhasil dipinjam.');
    }

    public function requestReturn($id) 
    {
        $borrow = Borrow::findOrFail($id);

        if ($borrow->status != 'pinjam') {
            return back()->with('error', 'Asset ini tidak dapat dikembalikan.');
        }
    
        $borrow->status = 'pending';
        $borrow->save();
    
        return back()->with('success', 'Permintaan pengembalian dikirim. Menunggu konfirmasi admin.');
}


public function confirmReturn($id)
{
    $borrow = Borrow::findOrFail($id);

    if ($borrow->status != 'pending') {
        return back()->with('error', 'Asset ini belum minta dikembalikan.');
    }

    // Tambahkan qty kembali ke stok
    $borrow->item->qty += $borrow->jumlah;
    $borrow->item->save();

    // Update status
    $borrow->status = 'kembali';
    $borrow->save();

    return back()->with('success', 'Pengembalian berhasil dikonfirmasi.');
}

public function rejectReturn($id)
{
    $borrow = Borrow::findOrFail($id);

    if ($borrow->status != 'pending') {
        return back()->with('error', 'Asset ini belum minta dikembalikan.');
    }

    // Batalkan permintaan pengembalian
    $borrow->status = 'hilang';
    $borrow->save();

    return back()->with('success', 'Permintaan pengembalian dibatalkan.');
}

public function myBorrows()
{
    $borrows = Borrow::with(['user', 'item'])
        ->where('user_id', Auth::id())
        ->orderByRaw("FIELD(status, 'pinjam', 'pending', 'kembali')")
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('assets.borrow_index', compact('borrows'));
}



}
