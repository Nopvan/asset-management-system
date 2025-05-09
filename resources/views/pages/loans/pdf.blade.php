<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Borrow List PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
        }

        .kop-container {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .kop-logo-left,
        .kop-logo-right {
            width: 80px;
            position: absolute;
            top: 0;
        }

        .kop-logo-left {
            left: 0;
        }

        .kop-logo-right {
            right: 0;
        }

        .kop-text {
            display: inline-block;
            width: 80%;
        }

        .kop-text h1 {
            margin: 2px;
            font-size: 20px;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px;
            font-size: 16px;
        }

        .kop-text p {
            margin: 2px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        thead {
            display: table-header-group;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @foreach ($borrows as $chunkIndex => $chunk)
        @if ($chunkIndex > 0)
            <div class="page-break"></div>
        @endif

        <!-- HEADER / KOP -->
        <div class="kop-container">
            <img src="{{ public_path('images/jabar.png') }}" class="kop-logo-left">
            <img src="{{ public_path('images/smk.png') }}" class="kop-logo-right">
            <div class="kop-text">
                <h2>YAYASAN RAHMAT LIL ALAMIN</h2>
                <h1>SMK NAGRAK PURWAKARTA</h1>
                <p>TERAKREDITASI B</p>
                <p>420/1024/DIKMEN/2016</p>
                <p>TEKNIK KOMPUTER JARINGAN – AGRIBISNIS TANAMAN PANGAN DAN HORTIKULTURA</p>
                <p>Jln. Raya Nagrak RT.004/002 Desa Nagrak Kec. Darangdan Purwakarta – 41163</p>
                <p>Email: smknagrakpwk@gmail.com</p>
            </div>
        </div>

        <h3 style="text-align: center;">Daftar Peminjaman Barang</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chunk as $borrow)
                    <tr>
                        <td>{{ $loop->parent->index * 10 + $loop->index + 1 }}</td>
                        <td>{{ $borrow->user->nama ?? '-' }}</td>
                        <td>{{ $borrow->item->item_name ?? '-' }}</td>
                        <td>{{ $borrow->jumlah }}</td>
                        <td>{{ ucfirst($borrow->status) }}</td>
                        <td>{{ $borrow->tanggal_pinjam ? \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') : '-' }}
                        </td>
                        <td>{{ $borrow->tanggal_kembali ? \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
