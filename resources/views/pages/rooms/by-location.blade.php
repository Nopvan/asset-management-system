@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/locations') }}">Lokasi</a></li>
                <li class="breadcrumb-item"><a href="{{ route('locations.show', $location->id) }}">{{ $location->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ruangan</li>
            </ol>
        </nav>

        <h3 class="mb-4">Ruangan di Lokasi: {{ $location->name }}</h3>

        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Area(m²)</th>
                            <th>Jumlah Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $index => $room)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->area }}</td>
                                <td>{{ $room->items->count() }} Item</td>

                                <td>
                                    <a href="{{ route('items.byRoom', $room->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-box"></i> Lihat Item
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada ruangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
