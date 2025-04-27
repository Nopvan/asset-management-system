<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Aset - Peminjaman Aset Sekolah</title>
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
            <form class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Cari Nama Asset">
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected disabled>Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Peralatan Olahraga">Peralatan Olahraga</option>
                        <option value="Buku">Buku</option>
                        <!-- Tambah kategori lain -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected disabled>Pilih Lokasi</option>
                        <option value="Lab Komputer">Lab Komputer</option>
                        <option value="Perpustakaan">Perpustakaan</option>
                        <option value="Gudang">Gudang</option>
                        <!-- Tambah lokasi lain -->
                    </select>
                </div>
            </form>
        </div>

        <!-- List Asset -->
        <div class="row g-4">

            <!-- Asset Card Example (Kalau Quantity > 0 baru ditampilkan) -->
            <div class="col-md-4">
                <div class="card card-asset shadow-sm h-100">
                    <img src="{{ asset('images/laptop.jpg') }}" class="card-img-top" alt="Laptop">
                    <div class="card-body">
                        <h5 class="card-title">Laptop Dell Inspiron</h5>
                        <p class="card-text"><strong>Kondisi:</strong> Baik</p>
                        <a href="#" class="btn btn-primary btn-sm">Pinjam</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-asset shadow-sm h-100">
                    <img src="{{ asset('images/proyektor.jpg') }}" class="card-img-top" alt="Proyektor">
                    <div class="card-body">
                        <h5 class="card-title">Proyektor Epson X200</h5>
                        <p class="card-text"><strong>Kondisi:</strong> Sangat Baik</p>
                        <a href="#" class="btn btn-primary btn-sm">Pinjam</a>
                    </div>
                </div>
            </div>

            <!-- Tambah asset lain sesuai data -->

        </div>

    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
