<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pinjam Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body> @include('layouts.header')
    <div class="container py-5">
        <h2 class="mb-4">Form Peminjaman Ruangan</h2>

        <div class="card">
            <div class="card-body">

                <!-- Foto Ruangan -->
                <div class="text-center mb-4">
                    @if ($room->photo)
                        <img src="{{ asset('storage/' . $room->photo) }}" alt="Foto Ruangan" class="img-fluid rounded"
                            style="max-height: 250px;">
                    @else
                        <div class="img-placeholder py-5 text-muted bg-light">
                            <i class="fas fa-door-open fa-3x"></i>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('rooms.form_pinjam', $room->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" value="{{ $room->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daftar Aset di Ruangan Ini</label>
                        <ul class="list-group">
                            @forelse ($room->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->item_name }}
                                    <span class="badge bg-primary rounded-pill">{{ $item->qty }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Tidak ada aset dalam ruangan ini.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan / Keperluan</label>
                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                        @error('keterangan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success" onclick="disableSubmit(this)">Pinjam
                        Sekarang</button>
                    <a href="{{ route('rooms.indexborrow') }}" class="btn btn-secondary">Batal</a>
                </form>
                <script>
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
