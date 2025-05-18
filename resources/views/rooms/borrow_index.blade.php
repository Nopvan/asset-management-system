<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('layouts.header')

        <div class="container py-5 content flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Riwayat Peminjaman Ruangan</h2>
                <a href="/assets/borrow" class="btn btn-outline-secondary">
                    <i class="fas fa-boxes-stacked me-1"></i>Item
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roomLoans as $loan)
                        <tr>
                            <td>{{ $loan->room->name ?? '-' }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @if ($loan->status == 'pinjam')
                                    <span class="badge bg-primary">Pinjam</span>
                                @elseif($loan->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($loan->status == 'kembali')
                                    <span class="badge bg-success">Kembali</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('rooms.borrow.show', $loan->id) }}" class="btn btn-sm btn-info mx-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($loan->status == 'pinjam')
                                    <form method="POST" action="{{ route('room-loans.return', $loan->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin mau mengajukan pengembalian ruangan?')">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $roomLoans->links() }}
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
