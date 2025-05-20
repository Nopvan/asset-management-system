@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Room Loans</h1>
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="/loansitem" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-box fa-sm text-white-50"></i> List Item Loans
            </a>
            <a href="/borrow-room/export-pdf" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Table -->
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
                                    <th>Room</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($room_loans as $index => $loan)
                                    <tr>
                                        <td>{{ $room_loans->firstItem() + $index }}</td>
                                        <td>{{ $loan->user->nama ?? '-' }}</td>
                                        <td>{{ $loan->room->name ?? '-' }}</td>
                                        <td>
                                            @if ($loan->status == 'pending')
                                                <span>Pending</span>
                                            @elseif ($loan->status == 'pinjam')
                                                <span>Pinjam</span>
                                            @elseif ($loan->status == 'kembali')
                                                <span>Kembali</span>
                                            @elseif ($loan->status == 'menunggu_konfirmasi_kembali')
                                                <span>Menunggu Konfirmasi Kembali</span>
                                            @elseif ($loan->status == 'hilang')
                                                <span>Hilang</span>
                                            @endif
                                        </td>
                                        <td>{{ $loan->tanggal_pinjam }}</td>
                                        <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ url('/borrow-room/' . $loan->id) }}"
                                                    class="btn btn-sm btn-info mx-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if ($loan->status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success mx-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confAcc-{{ $loan->id }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @elseif ($loan->status == 'menunggu_konfirmasi_kembali')
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confReturn-{{ $loan->id }}">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No room loan data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $room_loans->links('pagination::bootstrap-5') }}
                        </div>

                        @foreach ($room_loans as $loan)
                            @include('pages.loans.conf_backroom_acc', ['loan' => $loan])
                            @include('pages.loans.conf_loanroom_acc', ['loan' => $loan])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
