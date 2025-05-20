<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman Ruangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- penting untuk responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="wrapper d-flex flex-column min-vh-100">
        @include('layouts.header')

        <div class="container py-4 content flex-grow-1">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
                <h2 class="mb-0">Riwayat Peminjaman Ruangan</h2>
                <a href="/assets/borrow" class="btn btn-outline-secondary">
                    <i class="fas fa-boxes-stacked me-1"></i>Item
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
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
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <a href="{{ route('rooms.borrow.show', $loan->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($loan->status == 'pinjam')
                                            <form action="{{ route('room_loans.request_return', $loan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Kembalikan ruangan ini sekarang?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-undo"></i> Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $roomLoans->links() }}
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
