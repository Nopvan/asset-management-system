@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h1 class="h3 text-gray-800">Room Loan Details</h1>
        <a href="/borrow-room" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Detail Info -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5><strong>User:</strong> {{ $roomLoan->user->nama ?? '-' }}</h5>
            <h5><strong>Room:</strong> {{ $roomLoan->room->name ?? '-' }}</h5>
            <h5><strong>Status:</strong>
                @if ($roomLoan->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif ($roomLoan->status == 'pinjam')
                    <span class="badge bg-info">Pinjam</span>
                @elseif ($roomLoan->status == 'kembali')
                    <span class="badge bg-success">Kembali</span>
                @elseif ($roomLoan->status == 'hilang')
                    <span class="badge bg-danger">Hilang</span>
                @endif
            </h5>
            <h5><strong>Borrow Date:</strong> {{ $roomLoan->tanggal_pinjam }}</h5>
            <h5><strong>Return Date:</strong> {{ $roomLoan->tanggal_kembali ?? '-' }}</h5>
            <h5><strong>Description:</strong> {{ $roomLoan->keterangan ?? '-' }}</h5>

            <div class="mt-3">
                <h5><strong>Photo Saat Diterima:</strong></h5>
                @if ($roomLoan->photo_diterima)
                    <img src="{{ asset('storage/' . $roomLoan->photo_diterima) }}" alt="Photo Diterima"
                        class="img-fluid rounded mb-3" style="max-height: 250px;">
                @else
                    <p class="text-muted">Tidak ada foto saat diterima.</p>
                @endif

                <h5><strong>Photo Saat Dikembalikan:</strong></h5>
                @if ($roomLoan->photo_dikembalikan)
                    <img src="{{ asset('storage/' . $roomLoan->photo_dikembalikan) }}" alt="Photo Dikembalikan"
                        class="img-fluid rounded" style="max-height: 250px;">
                @else
                    <p class="text-muted">Belum ada foto pengembalian.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Item List -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Items yang Dipinjam</h6>
        </div>
        <div class="card-body">
            @if ($roomLoan->itemLoans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center text-dark">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Jumlah Dipinjam</th>
                                <th>Jumlah Kembali</th>
                                <th>Jumlah Hilang</th>
                                <th>Jumlah Rusak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomLoan->itemLoans as $index => $itemLoan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $itemLoan->item->item_name ?? '-' }}</td>
                                    <td>{{ $itemLoan->item->category->cat_name ?? '-' }}</td>
                                    <td>{{ $itemLoan->jumlah }}</td>
                                    <td>{{ $itemLoan->jumlah_kembali }}</td>
                                    <td>{{ $itemLoan->jumlah_hilang }}</td>
                                    <td>{{ $itemLoan->jumlah_rusak }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">Tidak ada item yang dipinjam.</p>
            @endif
        </div>
    </div>
@endsection
