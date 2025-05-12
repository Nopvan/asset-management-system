@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4">Detail Aset</h3>

        <div class="row align-items-start">
            <!-- Bagian Gambar -->
            <div class="col-md-4 mb-4 d-flex justify-content-center align-items-center"
                style="height: 300px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.25rem;">
                @if ($item->photo != null)
                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->item_name }}"
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
                            <th scope="row" style="width: 200px;">Nama Aset</th>
                            <td>{{ $item->item_name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $item->category->cat_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>
                                {{ ucfirst($item->conditions) }}
                                {{-- @if ($item->conditions == 'good')
                                    <span class="badge bg-success">Baik</span>
                                @elseif ($item->conditions == 'lost')
                                    <span class="badge bg-warning text-dark">Hilang</span>
                                @else
                                    <span class="badge bg-danger">Rusak</span>
                                @endif --}}
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $item->qty }} unit</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $item->locations }}</td>
                        </tr>
                        <tr>
                            <th>Diunggah Pada</th>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                    </tbody>
                </table>

                <a href="{{ url('/item') }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>
@endsection
