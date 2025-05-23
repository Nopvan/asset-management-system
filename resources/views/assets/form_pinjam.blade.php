<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- penting untuk responsif --}}
    <title>Pinjam Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .img-placeholder {
            width: 250px;
            height: 250px;
            border: 1px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1rem;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="container py-5">
        <h2 class="mb-4">Form Peminjaman Asset</h2>

        <div class="card">
            <div class="card-body">

                <!-- Foto Asset -->
                <div class="text-center mb-4">
                    @if ($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" alt="Foto Asset" class="img-fluid rounded"
                            style="max-height: 250px;">
                    @else
                        <div class="img-placeholder">
                            <i class="fas fa-image fa-5x text-secondary"></i>
                        </div>
                    @endif
                </div>

                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('assets.form_pinjam', $item->id) }}">
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
                        <label class="form-label">Ruangan</label>
                        <input type="text" class="form-control" value="{{ $item->room->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah yang Mau Dipinjam</label>
                        <input type="number" name="jumlah" class="form-control" min="1"
                            max="{{ $item->qty }}" required>
                        @error('jumlah')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan / Keperluan</label>
                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                        @error('keterangan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Peminjaman (foto/pdf)</label>
                        <input type="file" name="photo_diterima" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                            required>
                        @error('photo_diterima')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success" onclick="disableSubmit(this)">Pinjam
                        Sekarang</button>
                    <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
                </form>

                <script>
                    // Cegah submit form saat user tekan Enter di input manapun
                    document.querySelector('form').addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                        }
                    });

                    function disableSubmit(btn) {
                        btn.disabled = true;
                        btn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...`;
                        setTimeout(() => {
                            btn.closest('form').submit();
                        }, 100);
                    }
                </script>

            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
