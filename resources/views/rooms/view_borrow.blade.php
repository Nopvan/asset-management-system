<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('layouts.header')

        <div class="container py-5 content flex-grow-1">
            <a href="/rooms/borrow" class="btn btn-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
            </a>

            <h2 class="mb-3">Detail Peminjaman Ruangan</h2>

            <div class="mb-4">
                <p><strong>Nama Ruangan:</strong> {{ $roomLoan->room->room_name }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $roomLoan->tanggal_pinjam }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $roomLoan->tanggal_kembali ?? '-' }}</p>
                <p><strong>Status:</strong>
                    @if ($roomLoan->status == 'pinjam')
                        <span class="badge bg-primary">Pinjam</span>
                    @elseif($roomLoan->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($roomLoan->status == 'kembali')
                        <span class="badge bg-success">Kembali</span>
                    @endif
                </p>
            </div>

            <h4>Daftar Item yang Dipinjam</h4>

            @if ($roomLoan->itemLoans->count())
                <table class="table table-bordered text-center mt-3">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roomLoan->itemLoans as $itemLoan)
                            <tr>
                                <td>{{ $itemLoan->item->item_name ?? '-' }}</td>
                                <td>{{ $itemLoan->jumlah }}</td>
                                <td>
                                    @if ($itemLoan->status == 'pinjam')
                                        <span class="badge bg-primary">Pinjam</span>
                                    @elseif($itemLoan->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($itemLoan->status == 'kembali')
                                        <span class="badge bg-success">Kembali</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Tidak ada item yang dipinjam dalam ruangan ini.</p>
            @endif
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
