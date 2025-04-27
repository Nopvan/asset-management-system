@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ASSETS</h1>
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="/item/create" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add Item
            </a>
            <a href="/item/export-pdf" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-file-import fa-sm text-white-50"></i> Import
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
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Condition</th>
                                    <th>Quantity</th>
                                    <th>Location</th>
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
                                        <td>{{ $item->locations }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('item.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning mx-1">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                                    data-bs-toggle="modal" data-bs-target="#confDelete-{{ $item->id }}">
                                                    <i class="fas fa-eraser"></i>
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
