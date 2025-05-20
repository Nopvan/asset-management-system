<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Peminjaman Aset Sekolah</title>
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
            display: flex;
            flex-direction: column;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('{{ asset('images/smknagrak.png') }}') center center/cover no-repeat;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            text-align: center;
            padding: 2rem 1rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .btn-login,
        .btn-aset {
            background-color: #f8f9fa;
            color: #000000;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
            letter-spacing: 1px;
            padding: 0.5rem 1.5rem;
        }

        .btn-login:hover,
        .btn-aset:hover {
            background-color: #28a745;
            color: #ffffff;
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero h2 {
                font-size: 1.2rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .btn-login,
            .btn-aset {
                font-size: 0.9rem;
                padding: 0.4rem 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    @include('layouts.header')

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Hero Section -->
        <section class="hero">
            <h1 class="display-4 fw-bold">SELAMAT DATANG</h1>
            <h2>Di Sistem Manajemen Aset SMK Nagrak Purwakarta</h2>
            <p class="lead">Sistem ini menyediakan kemudahan dalam pengelolaan aset untuk mendukung kegiatan
                operasional sekolah secara efisien dan transparan.</p>
            @guest
                <a href="/login" class="btn btn-login btn-sm mt-2">LOGIN</a>
            @else
                <a href="/assets" class="btn btn-aset btn-sm mt-2">ASSETS</a>
            @endguest
        </section>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
