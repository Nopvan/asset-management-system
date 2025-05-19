@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Item Loans</h1>
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="/borrow-room" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-house fa-sm text-white-50"></i> List Room Loans
            </a>
            <a href="/borrow/export-pdf" class="btn btn-sm btn-danger shadow-sm">
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
                        <table class="table table-bordered text-center text-dark">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>From</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $index => $loan)
                                    <tr>
                                        <td>{{ $loans->firstItem() + $index }}</td>
                                        <td>{{ $loan->user->nama ?? '-' }}</td>
                                        <td>{{ $loan->item->item_name ?? '-' }}</td>
                                        <td>{{ $loan->jumlah }}</td>
                                        <td>
                                            @if ($loan->status == 'pending')
                                                <span>Pending</span>
                                            @elseif ($loan->status == 'pinjam')
                                                <span>Pinjam</span>
                                            @elseif ($loan->status == 'kembali')
                                                <span>Kembali</span>
                                            @elseif ($loan->status == 'hilang')
                                                <span>Hilang</span>
                                            @elseif ($loan->status == 'menunggu_konfirmasi_kembali')
                                                <span>Menunggu Konfirmasi Kembali</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($loan->room_loan_id)
                                                <span>
                                                    {{ $loan->room->room->name }}</span>
                                            @else
                                                <span>Manual</span>
                                            @endif
                                        </td>
                                        <td>{{ $loan->tanggal_pinjam }}</td>
                                        <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('item_loans.show', $loan->id) }}"
                                                    class="btn btn-sm btn-info mx-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($loan->status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#accModal-{{ $loan->id }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @elseif ($loan->status == 'menunggu_konfirmasi_kembali')
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#accBackModal-{{ $loan->id }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        @include('pages.loans.conf_loan_acc')
                                        @include('pages.loans.conf_back_acc')
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">No item loan data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $loans->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
