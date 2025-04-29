<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.header')

    <div class="container py-5">
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
                @foreach ($borrows as $borrow)
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
                @endforeach
            </tbody>
        </table>


        {{ $borrows->links() }}

    </div>

    @include('layouts.footer')
</body>

</html>
