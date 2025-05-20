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
        $statuses = ['menunggu_konfirmasi_kembali','pending', 'pinjam', 'kembali'];
        $room_loans = RoomLoan::with(['user', 'room'])
            ->whereIn('status', $statuses)
            ->orderByRaw("FIELD(status,'menunggu_konfirmasi_kembali' 'pending', 'pinjam', 'kembali')")
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

    public function accept(RoomLoan $roomLoan)
    {
        DB::beginTransaction();

        try {
            // Ubah status room menjadi 0
            $roomLoan->room->update(['status' => 0]);

            // Ubah status roomLoan
            $roomLoan->update(['status' => 'pinjam']);

            // Ambil semua itemLoan yang terkait dengan roomLoan ini
            foreach ($roomLoan->itemLoans as $itemLoan) {
                // Update status itemLoan jadi 'pinjam'
                $itemLoan->update(['status' => 'pinjam']);

                // Kurangi stok dari item aslinya
                $item = $itemLoan->item;
                if ($item->qty >= $itemLoan->jumlah) {
                    $item->qty -= $itemLoan->jumlah;
                    $item->save();
                } else {
                    throw new \Exception("Stok item '{$item->item_name}' tidak mencukupi.");
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Peminjaman ruangan berhasil di-ACC.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal meng-ACC peminjaman ruangan: ' . $e->getMessage());
        }
    }

    public function requestReturn($id)
    {
        $roomLoan = RoomLoan::findOrFail($id);

        if ($roomLoan->status != 'pinjam') {
            return back()->with('error', 'Ruangan ini tidak dalam status pinjam.');
        }

        // Ubah status room_loans
        $roomLoan->status = 'menunggu_konfirmasi_kembali';
        $roomLoan->save();

        // Ubah status semua item_loans yang terkait dengan room_loan ini
        $itemLoans = ItemLoan::where('room_loan_id', $roomLoan->id)->get();

        foreach ($itemLoans as $itemLoan) {
            if ($itemLoan->status === 'pinjam') {
                $itemLoan->status = 'menunggu_konfirmasi_kembali';
                $itemLoan->save();
            }
        }

        return back()->with('success', 'Permintaan pengembalian ruangan dikirim. Menunggu konfirmasi admin.');
    }

    public function returnRoom(Request $request, $id)
    {
        $request->validate([
            'photo_dikembalikan' => 'required|image|max:2048',
            'items' => 'required|array',
            'items.*.kembali' => 'required|integer|min:0',
            'items.*.hilang' => 'required|integer|min:0',
            'items.*.rusak' => 'required|integer|min:0',
        ]);

        $loan = RoomLoan::findOrFail($id);

        // Validasi jumlah kembali + hilang + rusak tidak boleh lebih dari jumlah pinjam
        foreach ($request->items as $itemId => $data) {
            $itemLoan = ItemLoan::where('room_loan_id', $loan->id)
                ->where('item_id', $itemId)
                ->first();

            if (!$itemLoan) {
                return redirect()->back()->withErrors('Data item tidak valid.');
            }

            $totalReturned = $data['kembali'] + $data['hilang'] + $data['rusak'];

            if ($totalReturned > $itemLoan->jumlah) {
                return redirect()->back()->withErrors("Jumlah item (kembali + hilang + rusak) untuk item {$itemLoan->item->item_name} tidak boleh lebih dari {$itemLoan->jumlah}.");
            }
        }

        // Simpan foto pengembalian
    if ($request->hasFile('photo_dikembalikan')) {
        $filename = time() . '_' . $request->file('photo_dikembalikan')->getClientOriginalName();
        $request->file('photo_dikembalikan')->move(public_path('storage/uploads/room-returns'), $filename);
        $loan->photo_dikembalikan = 'uploads/room-returns/' . $filename;
    }

        $loan->tanggal_kembali = now();
        $loan->status = 'kembali';
        $loan->save();

        foreach ($request->items as $itemId => $data) {
            $itemLoan = ItemLoan::where('room_loan_id', $loan->id)
                ->where('item_id', $itemId)
                ->first();

            if ($itemLoan) {
                $itemLoan->jumlah_kembali = $data['kembali'];
                $itemLoan->jumlah_hilang = $data['hilang'];
                $itemLoan->jumlah_rusak = $data['rusak'];
                $itemLoan->save();

                // Update stok, hanya tambah jumlah_kembali
                $item = $itemLoan->item;
                $item->qty += $data['kembali'];
                $item->save();
            }
        }

        return redirect()->back()->with('success', 'Pengembalian ruangan berhasil dikonfirmasi.');
    }




}
