@extends('layouts.app')

@section('content')
    <style>
        .card-custom {
            border-radius: 0 !important;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-4px);
        }

        .card-custom:active {
            transform: translateY(-2px) scale(0.98);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        thead th.border-bottom-0 {
            border-bottom: none !important;
        }

        table.table-hover-custom tbody tr:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-flex" style="gap: 0.5rem;">
            {{-- <button class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Report
            </button>
            <button class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Quick Add
            </button> --}}
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">

        <div class="col-6 col-md-3 mb-3">
            <a href="/locations" style="text-decoration: none; color: inherit;">
                <div class="card shadow-sm border-0 card-custom">
                    <div class="card-body text-center">
                        <h6 class="text-secondary mb-2">Total Locations</h6>
                        <h3 class="mb-0">{{ $totalBuildings }}</h3>
                        <small class="text-muted"><i class="fas fa-door-open me-1"></i>{{ $totalRooms }} Total
                            Rooms</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <a href="/item" style="text-decoration: none; color: inherit;">
                <div class="card shadow-sm border-0 card-custom">
                    <div class="card-body text-center">
                        <h6 class="text-secondary mb-2">Total Items</h6>
                        <h3 class="mb-0">{{ $totalItems }}</h3>
                        <small class="text-muted"><i class="fas fa-boxes me-1"></i>All asset items</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card shadow-sm border-0 card-custom">
                <div class="card-body text-center">
                    <h6 class="text-secondary mb-2">Good Condition</h6>
                    <h3 class="mb-0">{{ $goodCondition }}</h3>
                    @php
                        $percentGood = $totalItems > 0 ? round(($goodCondition / $totalItems) * 100) : 0;
                    @endphp
                    <small class="text-muted"><i class="fas fa-check-circle me-1"></i>{{ $percentGood }}% of total</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card shadow-sm border-0 card-custom">
                <div class="card-body text-center">
                    <h6 class="text-secondary mb-2">Damaged Assets</h6>
                    <h3 class="mb-0">{{ $damagedAssets }}</h3>
                    @php
                        $percentDamaged = $totalItems > 0 ? round(($damagedAssets / $totalItems) * 100) : 0;
                    @endphp
                    <small class="text-muted"><i class="fas fa-exclamation-triangle me-1"></i>{{ $percentDamaged }}% of
                        total</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Recent Activities</h5>
                        <a href="/loansitem" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center mb-0 table-hover-custom">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-bottom-0">User</th>
                                    <th class="border-bottom-0">Item</th>
                                    <th class="border-bottom-0">Quantity</th>
                                    <th class="border-bottom-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentActivities as $activity)
                                    <tr>
                                        <td>{{ $activity->user->nama ?? 'N/A' }}</td>
                                        <td>{{ $activity->item->item_name ?? 'N/A' }}</td>
                                        <td>{{ $activity->jumlah }}</td>
                                        <td>
                                            @php
                                                $statusClass = match ($activity->status) {
                                                    'kembali' => 'bg-success text-dark',
                                                    'pinjam' => 'bg-warning text-dark',
                                                    'pending' => 'bg-danger text-dark',
                                                    default => 'bg-secondary text-dark',
                                                };
                                            @endphp
                                            <span
                                                class="badge {{ $statusClass }}">{{ ucfirst($activity->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No recent activities found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
