@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/locations') }}">Lokasi</a></li>
            <li class="breadcrumb-item"><a href="{{ route('locations.show', $location->id) }}">{{ $location->name }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('rooms.byLocation', $location->id) }}">{{ $room->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Item</li>
        </ol>
    </nav>

    <h3 class="mb-4">Item di Ruangan: {{ $room->name }}</h3>

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
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Condition</th>
                                    <th>Quantity</th>
                                    <th>Room</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $index }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->category->cat_name }}</td>
                                        <td>{{ ucfirst($item->conditions) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->room->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('item.show', $item->id) }}"
                                                    class="btn btn-sm btn-info mx-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('item.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning mx-1">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confDelete-{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @include('pages.items.conf-delete')
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Data Not Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $items->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
