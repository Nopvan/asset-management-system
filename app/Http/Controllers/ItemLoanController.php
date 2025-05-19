<?php

namespace App\Http\Controllers;

use App\Models\ItemLoan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ItemLoanController extends Controller
{
    public function index()
    {
        $loans = ItemLoan::with(['item', 'user', 'room.room'])
        ->orderByRaw("FIELD(status, 'pending', 'pinjam', 'kembali') ASC")
        ->orderByRaw("ISNULL(room_loan_id) DESC")
        ->latest()
        ->paginate(10);

        return view('pages.loans.index', compact('loans'));
    }

    public function show($id)
    {
        $itemLoan = ItemLoan::with(['user', 'item', 'room.room'])
            ->findOrFail($id);

        return view('pages.loans.view_item_loan', compact('itemLoan'));
    }

    public function create(Item $item)
    {
        return view('item_loans.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        // Validasi input, termasuk file foto peminjaman
        $validatedData = $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . ($item->qty ?? 0),
            'keterangan' => 'required|string',
            'photo_diterima' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo_diterima')) {
            $filename = time() . '_' . $request->file('photo_diterima')->getClientOriginalName();
            $request->file('photo_diterima')->move(public_path('storage/uploads/item-loans'), $filename);
            $path = 'uploads/item-loans/' . $filename;
        }

        // Simpan data peminjaman
        $loan = ItemLoan::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'room_loan_id' => null,
            'jumlah' => $validatedData['jumlah'],
            'status' => 'pending',
            'tanggal_pinjam' => now(),
            'keterangan' => $validatedData['keterangan'],
            'photo_diterima' => $path,
        ]);

        return redirect()->route('assets.borrow.index')->with('success', 'Peminjaman berhasil diajukan dan menunggu persetujuan.');
    }

    public function accept($id)
    {
        try {
            $loan = ItemLoan::findOrFail($id);
            $item = $loan->item;

            if (!$item) {
                return back()->with('error', 'Data item tidak ditemukan untuk peminjaman ini.');
            }

            // Cek stok cukup
            if ($item->qty < $loan->jumlah) {
                return back()->with('error', 'Stok tidak cukup untuk menyetujui peminjaman.');
            }

            // Kurangi stok
            $item->qty -= $loan->jumlah;
            $item->save();

            // Update status peminjaman
            $loan->status = 'pinjam';
            $loan->save();

            return back()->with('success', 'Peminjaman berhasil diterima.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


public function returnItem(Request $request, $id)
    {
        $loan = ItemLoan::findOrFail($id);

        $request->validate([
            'jumlah_kembali' => 'required|integer|min:0',
            'jumlah_hilang' => 'required|integer|min:0',
            'jumlah_rusak' => 'required|integer|min:0',
            'photo_dikembalikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $total = $request->jumlah_kembali + $request->jumlah_hilang + $request->jumlah_rusak;

        if ($total > $loan->jumlah) {
            return back()->with('error', 'Jumlah kembali + hilang + rusak tidak boleh lebih dari jumlah pinjaman.');
        }

        // Simpan foto pengembalian jika ada
        $photoPath = null;
        if ($request->hasFile('photo_kembali')) {
            $filename = time() . '_' . $request->file('photo_kembali')->getClientOriginalName();
            $request->file('photo_kembali')->move(public_path('storage/uploads/item-returns'), $filename);
            $photoPath = 'uploads/item-returns/' . $filename;
        }

        // Update data peminjaman
        $loan->jumlah_kembali = $request->jumlah_kembali;
        $loan->jumlah_hilang = $request->jumlah_hilang;
        $loan->jumlah_rusak = $request->jumlah_rusak;
        $loan->photo_dikembalikan = $photoPath;
        $loan->status = 'kembali';
        $loan->tanggal_kembali = now();
        $loan->save();

        // Update stok item (kembali ke stok)
        if ($loan->item) {
            $loan->item->qty += $request->jumlah_kembali;
            $loan->item->save();
        }

        return redirect()->route('borrow.index')->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }


    public function exportPdf()
    {
        $item_loans = ItemLoan::with(['user', 'item'])->latest()->get()->chunk(10);
        $pdf = PDF::loadView('pages.loans.pdf', ['item_loans' => $item_loans]);
        return $pdf->download('item_loans.pdf');
    }
}
