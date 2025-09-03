<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ------------------ Dashboard ------------------
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('is_available', true)->count();
        $totalBookings = Booking::count();
        $activeBookings = Booking::whereDate('check_out', '>=', Carbon::today())->count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalBookings',
            'activeBookings',
            'totalUsers'
        ));
    }

    // ------------------ Rooms ------------------
    public function roomsIndex()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function createRoom()
    {
        return view('admin.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create($request->only('name', 'type', 'price', 'capacity'));

        return redirect()->route('admin.rooms.index')->with('status', 'Room created successfully!');
    }

    public function editRoom(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
        ]);

        $room->update($request->only('name', 'type', 'price', 'capacity', 'is_available'));

        return redirect()->route('admin.rooms.index')->with('status', 'Room updated successfully!');
    }

    public function deleteRoom(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('status', 'Room deleted successfully!');
    }

    // ------------------ Bookings ------------------
    public function bookingsIndex()
    {
        $bookings = Booking::with('user', 'room')->orderBy('created_at', 'desc')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function deleteBooking(Booking $booking)
    {
        // Mark room available again
        $booking->room->update(['is_available' => true]);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('status', 'Booking deleted successfully!');
    }

    // ------------------ Users ------------------
    public function usersIndex(Request $request)
    {
        $query = User::query();

        // Filter by name or email if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
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

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully!');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully!');
    }
}
