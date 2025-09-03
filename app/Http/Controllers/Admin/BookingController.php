<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Show all bookings with optional filters
    public function index(Request $request)
    {
        $query = Booking::with(['room', 'user']);

        // Filter by user name
        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->whereHas('room', function($q) use ($request) {
                $q->where('type', 'like', '%' . $request->room_type . '%');
            });
        }

        // Filter by check-in or check-out date
        if ($request->filled('date')) {
            $query->where(function($q) use ($request) {
                $q->where('check_in', $request->date)
                  ->orWhere('check_out', $request->date);
            });
        }

        $bookings = $query->orderBy('check_in', 'desc')->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    // Cancel a booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Mark the room as available again
        $booking->room->update(['is_available' => true]);

        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('status', 'Booking cancelled successfully.');
    }
}
