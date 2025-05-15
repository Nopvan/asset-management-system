<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Ruangan - Peminjaman Ruangan Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
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

        .card-room {
            transition: transform 0.2s;
        }

        .card-room:hover {
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
    </style>
</head>

<body>
    <!-- Navbar -->
    @include('layouts.header')

    <!-- Content Wrapper -->
    <div class="content-wrapper container">

        <!-- Search Bar -->
        <div class="search-bar shadow-sm">
            <form class="row g-3 align-items-end" method="GET" action="{{ route('rooms.indexborrow') }}">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Ruangan</label>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Cari Nama atau Lokasi" value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <label for="location_id" class="form-label">Lokasi</label>
                    <select class="form-select" name="location_id" id="location_id">
                        <option selected disabled>Pilih Lokasi</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->id }}"
                                {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('rooms.indexborrow') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- List Rooms -->
        <div class="row g-4">
            @forelse ($rooms as $room)
                <div class="col-md-4">
                    <div class="card card-room shadow-sm h-100">
                        @if ($room->photo && file_exists(public_path('storage/' . $room->photo)))
                            <img src="{{ asset('storage/' . $room->photo) }}" class="card-img-top"
                                alt="{{ $room->name }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-door-open"></i>
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <h5 class="card-title mb-1">{{ $room->name }}</h5>
                            <p class="card-text mb-1"><strong>Lokasi:</strong> {{ $room->location->name ?? '-' }}</p>
                            <p class="card-text mb-1"><strong>Luas:</strong> {{ $room->area ?? '-' }} m²</p>
                            @if (Auth::check() && Auth::user()->role === 'user')
                                <a href="{{ route('rooms.form_pinjam.form', $room->id) }}"
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
                        Tidak ada ruangan ditemukan.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $rooms->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
