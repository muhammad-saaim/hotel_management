<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class FeatureController extends Controller
{
    // Dashboard features overview
    public function index()
    {
        // You can add feature-related stats or quick links here
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();

        return view('admin.features.index', compact('totalRooms', 'totalBookings', 'totalUsers'));
    }

    // Reports page
    public function reports(Request $request)
    {
        // Example: generate booking report with optional filters
        $query = Booking::with('user', 'room');

        if ($request->filled('from_date')) {
            $query->whereDate('check_in', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('check_out', '<=', $request->to_date);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('admin.features.reports', compact('bookings'));
    }
}
