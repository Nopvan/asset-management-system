<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use Barryvdh\DomPDF\Facade\Pdf;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with('item', 'user')
            ->orderByRaw("FIELD(status, 'pending', 'hilang', 'pinjam', 'kembali')")
            ->latest()
            ->paginate(10);

        return view('pages.loans.index', compact('borrows'));
    }

    public function exportPdf()
    {
        $categories = Borrow::get()->chunk(10);

        $pdf = PDF::loadView('pages.loans.pdf', compact('borrows'));

        return $pdf->download('borrows.pdf');
    }
}
