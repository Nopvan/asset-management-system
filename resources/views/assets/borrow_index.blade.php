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
            <h2 class="mb-4">Riwayat Peminjaman</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Asset</th>
                        <th>Jumlah Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrows as $borrow)
                        <tr>
                            <td>{{ $borrow->item->item_name ?? '-' }}</td>
                            <td>{{ $borrow->jumlah }}</td>
                            <td>{{ $borrow->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                @if ($borrow->status == 'pinjam')
                                    <span class="badge bg-primary">Pinjam</span>
                                @elseif($borrow->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($borrow->status == 'kembali')
                                    <span class="badge bg-success">Kembali</span>
                                @endif
                            </td>
                            <td>
                                @if ($borrow->status == 'pinjam')
                                    <form method="POST" action="{{ route('assets.borrow.return', $borrow->id) }}">
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
                            <td colspan="5" class="text-center">Tidak ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $borrows->links() }}
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
