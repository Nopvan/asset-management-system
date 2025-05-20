<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pinjam Ruangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Biar responsif di HP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .img-placeholder {
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed #ccc;
            font-size: 1.2rem;
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            h2.mb-4 {
                font-size: 1.5rem;
                text-align: center;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .img-placeholder,
            .img-fluid {
                max-height: 180px !important;
            }

            .list-group-item {
                font-size: 0.9rem;
            }

            label.form-label {
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="container py-4">
        <h2 class="mb-4">Form Peminjaman Ruangan</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">

                {{-- Foto Ruangan --}}
                <div class="text-center mb-4">
                    @if ($room->photo)
                        <img src="{{ asset('storage/' . $room->photo) }}" alt="Foto Ruangan" class="img-fluid rounded"
                            style="max-height: 250px;">
                    @else
                        <div class="img-placeholder text-muted bg-light">
                            <i class="fas fa-door-open fa-3x"></i>
                        </div>
                    @endif
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('rooms.form_pinjam', $room->id) }}" enctype="multipart/form-data">
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
                        <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Diterima</label>
                        <input type="file" name="photo_diterima" class="form-control"
                            accept="image/*,application/pdf">
                        @error('photo_diterima')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="submit" class="btn btn-success" onclick="disableSubmit(this)">Pinjam
                            Sekarang</button>
                        <a href="{{ route('rooms.indexborrow') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>

                {{-- Prevent Enter Submit + Disable Button --}}
                <script>
                    document.querySelector('form').addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') e.preventDefault();
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
