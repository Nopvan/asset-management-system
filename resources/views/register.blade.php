<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Peminjaman Aset Sekolah</title>
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
            /* Added padding top and bottom */
        }

        .hero {
            /* background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('{{ asset('images/smknagrak.png') }}') center center/cover no-repeat; */
            display: flex;
            align-items: center;
            min-height: calc(100vh - 120px);
            /* Adjust based on header/footer height */
            color: white;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 2rem;
            margin: 2rem 0;
            /* Added margin top and bottom */
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
            <div class="container py-5"> <!-- Added py-5 for vertical padding -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6"> <!-- Adjusted column width -->
                        <div class="card shadow-lg"> <!-- Added shadow-lg for better depth -->
                            <h3 class="text-center mb-4">Buat Akun Baru</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama"
                                        placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username"
                                        placeholder="Masukkan Username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" class="form-control" id="kelas"
                                        placeholder="Contoh: XII RPL 1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="telepon"
                                        placeholder="Masukkan No Telepon" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Masukkan Email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Masukkan Password" required>
                                </div>
                                <div class="d-grid gap-2"> <!-- Added gap between buttons -->
                                    <button type="submit" class="btn btn-primary py-2">Daftar</button>
                                    <!-- Added py-2 -->
                                </div>
                            </form>
                            <div class="mt-4 text-center"> <!-- Increased margin top -->
                                <small>Sudah punya akun? <a href="/login" class="text-primary">Login di
                                        sini</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
