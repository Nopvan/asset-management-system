<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Aset - Peminjaman Aset Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1 0 auto;
            padding-top: 20px;
            padding-bottom: 40px;
        }

        .search-bar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .category-buttons {
            margin-bottom: 30px;
        }

        .card-asset {
            transition: transform 0.2s;
        }

        .card-asset:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            background-color: #f8f9fa;
        }

        .img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
            background-color: #e9ecef;
            color: #6c757d;
        }

        .img-placeholder i {
            font-size: 3rem;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* sama seperti .form-control Bootstrap */
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            /* border-radius Bootstrap 5 */
            display: flex;
            align-items: center;
        }

        .select2-selection__rendered {
            line-height: 24px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 0.35rem;
            right: 10px;
        }

        .select2-container {
            width: 100% !important;
            max-width: 100%;
            /* Biar nggak lebar melebihi parent col-md-3 */
        }

        .select2-dropdown {
            max-width: 100% !important;
            /* Batasi dropdown-nya juga */
            overflow-x: hidden;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    @include('layouts.header')

    <!-- Content Wrapper -->
    <div class="content-wrapper container">

        <!-- Search Bar -->
        <div class="search-bar shadow-sm">
            <form class="row g-3 align-items-end" method="GET" action="{{ route('assets.index') }}">
                {{-- Kolom Nama Aset --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Aset</label>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Cari Nama, Kategori, atau Ruangan" value="{{ request('search') }}">
                </div>

                {{-- Kolom Kategori --}}
                <div class="col-md-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori_id" id="kategori_id">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}"
                                {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->cat_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="room_id" class="form-label">Ruangan</label>
                    <select class="form-select" name="room_id" id="room_id">
                        <option value="">Pilih Ruangan</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Tombol Cari dan Reset --}}
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('assets.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- List Asset -->
        <div class="row g-4">
            @forelse ($items as $item)
                <div class="col-md-4">
                    <div class="card card-asset shadow-sm h-100">
                        @if ($item->photo && file_exists(public_path('storage/' . $item->photo)))
                            <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top"
                                alt="{{ $item->item_name }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <h5 class="card-title mb-1">{{ $item->item_name }}</h5>
                            <p class="card-text mb-1"><strong>Kondisi:</strong> {{ $item->conditions }}</p>
                            <p class="card-text mb-1"><strong>Ruangan:</strong> {{ $item->room->name ?? '-' }}</p>
                            <p class="card-text mb-1"><strong>Stok:</strong> {{ $item->qty }}</p>
                            @if (Auth::check() && Auth::user()->role === 'user')
                                <a href="{{ route('assets.form_pinjam.form', $item->id) }}"
                                    class="btn btn-primary btn-sm mt-2">Pinjam</a>
                            @else
                                <button class="btn btn-secondary btn-sm mt-2" disabled>Pinjam</button>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Tidak ada asset ditemukan.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (dibutuhkan oleh Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#kategori_id').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                dropdownParent: $('body')
            });

            $('#room_id').select2({
                placeholder: "Pilih Ruangan",
                allowClear: true,
                dropdownParent: $('body')
            });
        });
    </script>

</body>

</html>
