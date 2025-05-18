@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h1 class="h3 text-gray-800">Room Loan Details</h1>
        <a href="/borrow-room" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Detail Info -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5><strong>User:</strong> {{ $roomLoan->user->nama ?? '-' }}</h5>
            <h5><strong>Room:</strong> {{ $roomLoan->room->name ?? '-' }}</h5>
            <h5><strong>Status:</strong>
                @if ($roomLoan->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif ($roomLoan->status == 'pinjam')
                    <span class="badge bg-info">Pinjam</span>
                @elseif ($roomLoan->status == 'kembali')
                    <span class="badge bg-success">Kembali</span>
                @elseif ($roomLoan->status == 'hilang')
                    <span class="badge bg-danger">Hilang</span>
                @endif
            </h5>
            <h5><strong>Borrow Date:</strong> {{ $roomLoan->tanggal_pinjam }}</h5>
            <h5><strong>Return Date:</strong> {{ $roomLoan->tanggal_kembali ?? '-' }}</h5>
        </div>
    </div>

    <!-- Item List -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Items in Room</h6>
        </div>
        <div class="card-body">
            @if ($roomLoan->room->items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center text-dark">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomLoan->room->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->category->cat_name }}</td>
                                    <td>{{ $item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No items found in this room.</p>
            @endif
        </div>
    </div>
@endsection
