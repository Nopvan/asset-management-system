<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pinjam Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    @include('layouts.header')

    <div class="container py-5">
        <h2 class="mb-4">Form Peminjaman Asset</h2>

        <div class="card">
            <div class="card-body">

                <!-- Foto Asset -->
                <div class="text-center mb-4">
                    @if ($item->image)
                        <img src="{{ asset('images/' . $item->image) }}" alt="Foto Asset" class="img-fluid rounded"
                            style="max-height: 250px;">
                    @else
                        <div class="img-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('assets.pinjam', $item->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Asset</label>
                        <input type="text" class="form-control" value="{{ $item->item_name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok Tersedia</label>
                        <input type="text" class="form-control" value="{{ $item->qty }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control" value="{{ $item->locations }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah yang Mau Dipinjam</label>
                        <input type="number" name="jumlah" class="form-control" min="1"
                            max="{{ $item->qty }}" required>
                        @error('jumlah')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Pinjam Sekarang</button>
                    <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

    </div>

    @include('layouts.footer')
</body>

</html>
