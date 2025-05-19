@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Detail Peminjaman Item</h2>
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $itemLoan->user->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Item</th>
                        <td>{{ $itemLoan->item->item_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>{{ $itemLoan->jumlah }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Kembali</th>
                        <td>{{ $itemLoan->jumlah_kembali ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Hilang</th>
                        <td>{{ $itemLoan->jumlah_hilang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Rusak</th>
                        <td>{{ $itemLoan->jumlah_rusak ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($itemLoan->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($itemLoan->status == 'pinjam')
                                <span class="badge bg-info">Pinjam</span>
                            @elseif ($itemLoan->status == 'kembali')
                                <span class="badge bg-success">Kembali</span>
                            @elseif ($itemLoan->status == 'hilang')
                                <span class="badge bg-danger">Hilang</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Asal Ruangan</th>
                        <td>
                            @if ($itemLoan->room_loan_id)
                                {{ $itemLoan->room->room->name ?? 'Ruangan tidak ditemukan' }}
                            @else
                                Manual
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>{{ $itemLoan->tanggal_pinjam }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>{{ $itemLoan->tanggal_kembali ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $itemLoan->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Foto Saat Diterima</th>
                        <td>
                            @if ($itemLoan->photo_diterima)
                                <img src="{{ asset('storage/' . $itemLoan->photo_diterima) }}" alt="Photo Diterima"
                                    class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <span class="text-muted">Belum ada foto</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Foto Saat Dikembalikan</th>
                        <td>
                            @if ($itemLoan->photo_dikembalikan)
                                <img src="{{ asset('storage/' . $itemLoan->photo_dikembalikan) }}" alt="Photo Kembali"
                                    class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <span class="text-muted">Belum ada foto</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>
@endsection
