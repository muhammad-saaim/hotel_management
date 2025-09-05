<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Jobs\ProcessNewRoom;

class RoomController extends Controller
{
    // List all rooms
    public function index()
    {
        // Add active booking count for today
        $rooms = Room::withCount(['bookings as active_bookings_count' => function($query) {
            $query->whereDate('check_in', '<=', now())
                  ->whereDate('check_out', '>=', now());
        }])->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    // Show form to create a room
    public function create()
    {
        return view('admin.rooms.create');
    }

    // Store new room
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'is_available' => 'required|boolean', // manual availability for maintenance
        ]);

        // Create the room
        $room = Room::create($request->all());

        // Dispatch queued job to notify all users
        ProcessNewRoom::dispatch($room);

        return redirect()->route('admin.rooms.index')
                         ->with('status', 'Room added successfully! Users will be notified by email.');
    }

    // Show edit form
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    // Update room
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
        ]);

        $room->update($request->all());
        return redirect()->route('admin.rooms.index')->with('status', 'Room updated successfully!');
    }

    // Delete room
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('status', 'Room deleted successfully!');
    }
}
