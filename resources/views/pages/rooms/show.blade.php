@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Ruangan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $room->name }}</li>
            </ol>
        </nav>

        <h3 class="mb-4">Detail Ruangan</h3>

        <div class="row align-items-start">
            <!-- Bagian Gambar -->
            <div class="col-md-4 mb-4 d-flex justify-content-center align-items-center"
                style="height: 300px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.25rem;">
                @if ($room->photo)
                    <img src="{{ asset('storage/' . $room->photo) }}" alt="{{ $room->name }}"
                        class="img-fluid rounded shadow-sm" style="max-height: 100%; object-fit: contain;">
                @else
                    <span class="text-muted">No Image Available</span>
                @endif
            </div>

            <!-- Bagian Info -->
            <div class="col-md-8">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <th style="width: 200px;">Nama Ruangan</th>
                            <td>{{ $room->name }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $room->location->name }}</td>
                        </tr>
                        <tr>
                            <th>Luas Area</th>
                            <td>{{ $room->area }} m²</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($room->status) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Barang</th>
                            <td>{{ $room->items->count() }} Barang</td>
                        </tr>
                        <tr>
                            <th>Diunggah Pada</th>
                            <td>{{ $room->created_at->format('d M Y') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex flex-wrap mt-3" style="gap: 0.5rem;">
                    <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <a href="{{ route('items.byRoom', $room->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-box"></i> Lihat Item
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
