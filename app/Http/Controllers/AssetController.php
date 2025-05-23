<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Borrow;
use App\Models\Room;
use App\Models\Location;
use App\Models\ItemLoan;
use App\Models\RoomLoan;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{

 public function index(Request $request)
{
    // Ambil kategori yang memiliki item dengan qty > 0 dan kondisi good
    $kategori = Category::whereHas('items', function ($query) {
        $query->where('qty', '>', 0)
              ->where('conditions', 'good');
    })->get();

    // Ambil rooms yang memiliki item dengan qty > 0 dan kondisi good
    $rooms = Room::whereHas('items', function ($query) {
        $query->where('qty', '>', 0)
              ->where('conditions', 'good');
    })->get();

    // Query utama untuk ambil item
    $query = Item::with(['category', 'room'])
                ->where('qty', '>', 0)
                ->where('conditions', 'good');

    // Filter nama item
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('item_name', 'like', "%$search%")
              ->orWhereHas('category', function ($qc) use ($search) {
                  $qc->where('cat_name', 'like', "%$search%");
              })
              ->orWhereHas('room', function ($qr) use ($search) {
                  $qr->where('name', 'like', "%$search%");
              });
        });
    }

    // Filter kategori
    if ($request->filled('kategori_id')) {
        $query->where('cat_id', $request->kategori_id);
    }

    // Filter room
    if ($request->filled('room_id')) {
        $query->where('room_id', $request->room_id);
    }

    // Jika tanpa filter, order berdasarkan qty terbanyak
    if (!$request->filled('search') && !$request->filled('kategori_id') && !$request->filled('room_id')) {
        $query->orderBy('qty', 'desc');
    }

    $items = $query->paginate(9)->withQueryString();

    return view('assets.index', compact('items', 'kategori', 'rooms'));
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
        $loan = ItemLoan::findOrFail($id);

        if ($loan->status != 'pinjam') {
            return back()->with('error', 'Asset ini tidak dapat dikembalikan.');
        }
    
        $loan->status = 'menunggu_konfirmasi_kembali';
        $loan->save();
    
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
    $borrow->tanggal_kembali = now();
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
    $itemLoans = ItemLoan::with(['user', 'item'])
        ->where('user_id', Auth::id())
        ->orderByRaw("FIELD(status, 'pinjam', 'pending', 'kembali')")
        ->orderByDesc('tanggal_pinjam')
        ->paginate(10);

    return view('assets.borrow_index', compact('itemLoans'));
}

public function myBorrowsRoom()
{
    $roomLoans = RoomLoan::with('room')
        ->where('user_id', Auth::id())
        ->orderByRaw("FIELD(status, 'pinjam', 'pending', 'kembali')")
        ->orderByDesc('tanggal_pinjam')
        ->paginate(10);

    return view('rooms.borrow_index', compact('roomLoans'));
}

public function showBorrowRoom($id)
{
    $roomLoan = RoomLoan::with(['room', 'itemLoans.item'])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

    return view('rooms.view_borrow', compact('roomLoan'));
}


public function indexBorrowRoom(Request $request)
{
    $query = Room::with('location')->where('status', '!=', 0);

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->location_id) {
        $query->where('location_id', $request->location_id);
    }

    return view('rooms.index', [
        'rooms' => $query->paginate(9),
        'locations' => Location::all(),
    ]);
}

public function showPinjamFormRoom($id)
{
    $room = Room::findOrFail($id);
    return view('rooms.form_pinjam', compact('room'));
}



}
