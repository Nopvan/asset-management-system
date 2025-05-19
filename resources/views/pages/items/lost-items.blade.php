@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lost Items</h1>
        <a href="/item" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Items
        </a>
    </div>

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
                                    <th>Room</th>
                                    <th>Lost from Loans</th>
                                    <th>Lost in Items Table</th>
                                    <th>Total Lost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    <tr>
                                        <td>{{ $items->firstItem() + $index }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->category->cat_name ?? '-' }}</td>
                                        <td>{{ $item->room->name ?? '-' }}</td>
                                        <td>{{ $item->total_lost_from_loans ?? 0 }}</td>
                                        <td>{{ $item->lost_from_items ?? 0 }}</td>
                                        <td>{{ ($item->total_lost_from_loans ?? 0) + ($item->lost_from_items ?? 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No lost item data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $items->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
