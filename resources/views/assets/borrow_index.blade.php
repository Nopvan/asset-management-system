<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('layouts.header')

        <div class="container py-5 content flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Riwayat Peminjaman Item</h2>
                <a href="/rooms/borrow" class="btn btn-outline-secondary">
                    <i class="fas fa-door-open me-1"></i> Ruangan
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Asset</th>
                        <th>Jumlah Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($itemLoans as $loan)
                        <tr>
                            <td>{{ $loan->item->item_name ?? '-' }}</td>
                            <td>{{ $loan->jumlah }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>
                                {{ $loan->tanggal_kembali ?? '-' }}
                            </td>
                            <td>
                                @if ($loan->status == 'pinjam')
                                    <span class="badge bg-primary">Pinjam</span>
                                @elseif($loan->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($loan->status == 'menunggu_konfirmasi_kembali')
                                    <span class="badge bg-info">Menunggu Konfirmasi Kembali</span>
                                @elseif($loan->status == 'kembali')
                                    <span class="badge bg-success">Kembali</span>
                                @endif
                            </td>
                            <td>
                                @if ($loan->status == 'pinjam')
                                    <form method="POST" action="{{ route('assets.borrow.return', $loan->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin mau mengajukan pengembalian?')">Kembalikan</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $itemLoans->links() }}
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
