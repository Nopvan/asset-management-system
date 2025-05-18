<?php

namespace App\Http\Controllers;

use App\Models\ItemLoan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function create(Item $item)
    {
        return view('item_loans.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $item->qty,
        ]);

        ItemLoan::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'room_loan_id' => null,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'tanggal_pinjam' => Carbon::now(),
        ]);

        return redirect()->route('item_loans.index')->with('success', 'Berhasil meminjam item.');
    }

    public function exportPdf()
    {
        $item_loans = ItemLoan::with(['user', 'item'])->latest()->get()->chunk(10);
        $pdf = PDF::loadView('pages.loans.pdf', ['item_loans' => $item_loans]);
        return $pdf->download('item_loans.pdf');
    }
}
