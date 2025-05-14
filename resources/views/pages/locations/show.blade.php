@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/locations') }}">Lokasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $location->name }}</li>
            </ol>
        </nav>

        <h3 class="mb-4">Detail Lokasi</h3>

        <div class="row align-items-start">
            <!-- Bagian Gambar -->
            <div class="col-md-4 mb-4 d-flex justify-content-center align-items-center"
                style="height: 300px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.25rem;">
                @if ($location->photo)
                    <img src="{{ asset('storage/' . $location->photo) }}" alt="{{ $location->name }}"
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
                            <th style="width: 200px;">Nama Lokasi</th>
                            <td>{{ $location->name }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $location->address }}</td>
                        </tr>
                        <tr>
                            <th>Luas Area</th>
                            <td>{{ $location->area }} m²</td>
                        </tr>
                        <tr>
                            <th>Jumlah Ruangan</th>
                            <td>{{ $location->rooms->count() }} Ruangan</td>
                        </tr>
                        <tr>
                            <th>Diunggah Pada</th>
                            <td>{{ $location->created_at->format('d M Y') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex flex-wrap mt-3" style="gap: 0.5rem;">
                    <a href="{{ url('/locations') }}" class="btn btn-outline-secondary">Kembali</a>
                    <a href="{{ route('rooms.byLocation', $location->id) }}" class="btn btn-primary">
                        <i class="fas fa-door-open me-1"></i> Lihat Ruangan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
