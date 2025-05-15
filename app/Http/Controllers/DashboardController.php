<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Room;
use App\Models\Item;
use App\Models\Borrow;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total buildings = jumlah lokasi
        $totalBuildings = Location::count();

        // Total rooms
        $totalRooms = Room::count();

        // Total items (sum qty)
        $totalItems = Item::sum('qty');

        // Good condition items count (assuming 'conditions' = 'good' means bagus)
        $goodCondition = Item::where('conditions', 'good')->sum('qty');

        // Damaged assets (conditions selain 'good')
        $damagedAssets = Item::where('conditions', '!=', 'good')->sum('qty');

        // Recent activities = recent borrow records with relations loaded
        $recentActivities = Borrow::with(['user', 'item'])
            ->latest('tanggal_pinjam')
            ->limit(3)
            ->get();

        return view('pages.dashboard', compact(
            'totalBuildings',
            'totalRooms',
            'totalItems',
            'goodCondition',
            'damagedAssets',
            'recentActivities'
        ));
    }
}
