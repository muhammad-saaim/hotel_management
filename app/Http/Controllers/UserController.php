<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Mail\BookingConfirmed;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Show user dashboard with featured rooms
     */
    public function index()
    {
        $rooms = Room::where('is_available', true)
                     ->latest()
                     ->take(3)
                     ->get();

        return view('user.home', compact('rooms'));
    }

    /**
     * Show user profile page
     */
    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
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

    /**
     * Show available rooms (exclude rooms with active bookings)
     */
    public function rooms()
    {
        $rooms = Room::whereDoesntHave('bookings', function ($query) {
            $query->active(); // Exclude rooms with active bookings
        })->get();

        return view('user.rooms', compact('rooms'));
    }

    /**
     * Book a room and send confirmation email
     */
    public function bookRoom(Request $request, int $roomId)
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

        if (!$room->isAvailableForDates($checkIn, $checkOut)) {
            return back()->withErrors(['room' => 'This room is not available for the selected dates.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'total_price' => $totalPrice,
        ]);

        // Send booking confirmation email
        Mail::to(Auth::user()->email)->send(new BookingConfirmed($booking));

        return redirect()->route('user.bookings')
            ->with('status', 'Room booked successfully! A confirmation email has been sent.');
    }

    /**
     * Show all bookings of the logged-in user
     */
    public function bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->get();

        return view('user.bookings', compact('bookings'));
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(int $bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $booking->room->update(['is_available' => true]);
        $booking->delete();

        return redirect()->route('user.bookings')
            ->with('status', 'Booking cancelled successfully.');
    }
}
