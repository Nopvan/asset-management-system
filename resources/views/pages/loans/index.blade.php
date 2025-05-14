@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Loan</h1>
        <a href="/borrow/export-pdf" class="btn btn-sm btn-danger shadow-sm">
            <i class="fas fa-file-pdf fa-sm text-white-50"></i> Export PDF
        </a>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center text-dark">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrows as $index => $borrow)
                                    <tr>
                                        <td>{{ $borrows->firstItem() + $index }}</td>
                                        <td>{{ $borrow->user->nama ?? '-' }}</td>
                                        <td>{{ $borrow->item->item_name ?? '-' }}</td>
                                        <td>{{ $borrow->jumlah }}</td>
                                        <td>
                                            @if ($borrow->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($borrow->status == 'pinjam')
                                                <span class="badge bg-info">Pinjam</span>
                                            @elseif ($borrow->status == 'kembali')
                                                <span class="badge bg-success">Kembali</span>
                                            @elseif ($borrow->status == 'hilang')
                                                <span class="badge bg-danger">Hilang</span>
                                            @endif
                                        </td>
                                        <td>{{ $borrow->tanggal_pinjam }}</td>
                                        <td>
                                            @if ($borrow->tanggal_kembali == null)
                                                -
                                            @else
                                                {{ $borrow->tanggal_kembali }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($borrow->status == 'pending')
                                                    <!-- Tombol ACC -->
                                                    <button type="button" class="btn btn-sm btn-success mx-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confAcc-{{ $borrow->id }}">
                                                        <i class="fas fa-check"></i> Acc
                                                    </button>

                                                    <!-- Tombol Decline -->
                                                    <button type="button" class="btn btn-sm btn-danger mx-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confDec-{{ $borrow->id }}">
                                                        <i class="fas fa-times"></i> Decline
                                                    </button>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                        @include('pages.loans.conf-acc')
                                        @include('pages.loans.conf-dec')
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No borrow data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $borrows->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
