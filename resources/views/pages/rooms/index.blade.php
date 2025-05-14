@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rooms</h1>
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add Room
            </a>
            <a href="{{ route('rooms.export.pdf') }}" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Room Name</th>
                                    <th>Location</th>
                                    <th>Area (m²)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $index => $room)
                                    <tr>
                                        <td>{{ $rooms->firstItem() + $index }}</td>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->location->name ?? '-' }}</td>
                                        <td>{{ $room->area }}</td>
                                        <td>
                                            @if ($room->status == 0)
                                                <span>Tidak Tersedia</span>
                                            @elseif ($room->status == 1)
                                                <span>Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('rooms.show', $room->id) }}"
                                                    class="btn btn-sm btn-info mx-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('rooms.edit', $room->id) }}"
                                                    class="btn btn-sm btn-warning mx-1">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                                    data-bs-toggle="modal" data-bs-target="#confDelete-{{ $room->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @include('pages.rooms.conf-delete')
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data Not Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $rooms->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
