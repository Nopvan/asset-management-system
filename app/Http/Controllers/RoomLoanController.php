<?php

namespace App\Http\Controllers;

use App\Models\RoomLoan;
use App\Models\ItemLoan;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class RoomLoanController extends Controller
{
    public function index()
    {
        $statuses = ['pending', 'pinjam', 'kembali'];
        $room_loans = RoomLoan::with(['user', 'room'])
            ->whereIn('status', $statuses)
            ->orderByRaw("FIELD(status, 'pending', 'pinjam', 'kembali')")
            ->latest()
            ->paginate(10);

        return view('pages.loans.room-loan', compact('room_loans', 'statuses'));
    }

    public function show($id)
    {
        $roomLoan = RoomLoan::with(['user', 'room.items'])->findOrFail($id);
        return view('pages.loans.view-room', compact('roomLoan'));
    }


    public function create(Room $room)
    {
        $items = $room->items;
        return view('room_loans.create', compact('room', 'items'));
    }

    public function store(Request $request, Room $room)
    {
                $request->validate([
            'keterangan' => 'required|string',
            'photo_diterima' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $status = 'pending';
            $tanggalPinjam = Carbon::now();

            // Simpan foto diterima jika ada
            $photoPath = null;
            if ($request->hasFile('photo_diterima')) {
                $filename = time() . '_' . $request->file('photo_diterima')->getClientOriginalName();
                $request->file('photo_diterima')->move(public_path('storage/uploads/room-loans'), $filename);
                $photoPath = 'uploads/room-loans/' . $filename;
            }

            // Buat peminjaman ruangan
            $roomLoan = RoomLoan::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'status' => $status,
                'tanggal_pinjam' => $tanggalPinjam,
                'keterangan' => $request->keterangan,
                'photo_diterima' => $photoPath,
            ]);

            if ($room->items->isEmpty()) {
                throw new \Exception('Tidak ada item dalam ruangan.');
            }

            foreach ($room->items as $item) {
                ItemLoan::create([
                    'user_id' => Auth::id(),
                    'item_id' => $item->id,
                    'room_loan_id' => $roomLoan->id,
                    'jumlah' => $item->qty ?? 1,
                    'status' => $status,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'keterangan' => 'Dipinjam otomatis dari ruangan',
                ]);
            }

            DB::commit();
            return redirect()->route('rooms.borrow.index')->with('success', 'Berhasil meminjam ruangan beserta seluruh isi.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Simpan log error untuk debug
            Log::error('Gagal menyimpan room loan: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Gagal meminjam ruangan: ' . $e->getMessage());
        }
    }

    
    public function exportPdf()
    {
        $room_loans = RoomLoan::with(['user', 'room'])
        ->latest()
        ->get()
        ->chunk(10); // Supaya bisa pecah halaman PDF
        $pdf = PDF::loadView('pages.loans.pdf-room', compact('room_loans'));
        return $pdf->download('room-loans.pdf');
    }


}
