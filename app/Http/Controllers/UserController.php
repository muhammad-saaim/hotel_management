<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class UserController extends Controller
{
    // Show user dashboard
    public function index()
    {
        return view('user.dashboard');
    }

    // Show profile page
    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    // -------------------- Step 21.3 (Improved with active bookings) --------------------

    // Show available rooms (filter out rooms that have active bookings)
    public function rooms()
    {
        $rooms = Room::whereDoesntHave('bookings', function ($query) {
            $query->active(); // exclude rooms with active bookings
        })->get();

        return view('user.rooms', compact('rooms'));
    }

    // Book a room
    public function bookRoom(Request $request, $roomId)
    {

        $room = Room::findOrFail($roomId);

        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $totalDays = $checkIn->diffInDays($checkOut);
        $totalPrice = $room->price * $totalDays;

        // Make sure room is free in that period
        if (!$room->isAvailableForDates($checkIn, $checkOut)) {
            return back()->withErrors(['room' => 'This room is not available for the selected dates.']);
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('user.bookings')->with('status', 'Room booked successfully!');
    }

    // Show all bookings of the logged-in user
    public function bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->get();

        return view('user.bookings', compact('bookings'));
    }

    // -------------------- Step 23: Cancel Booking --------------------

    // Cancel a booking
    public function cancelBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Optionally mark room available again (for backward compatibility)
        $booking->room->update(['is_available' => true]);

        $booking->delete();

        return redirect()->route('user.bookings')
            ->with('status', 'Booking cancelled successfully.');
    }
}
