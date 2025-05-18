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

    public function exportPdf()
    {
        $item_loans = ItemLoan::with(['user', 'item'])->latest()->get()->chunk(10);
        $pdf = PDF::loadView('pages.loans.pdf', ['item_loans' => $item_loans]);
        return $pdf->download('item_loans.pdf');
    }
}
