@extends('admin.layouts.app')

@section('title', 'Rooms Management')
@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">All Rooms</h2>

    @if(session('status'))
        <div style="background:#e6ffed; border:1px solid #28a745; color:#155724; padding:10px; border-radius:5px; margin-bottom:20px;">
            {{ session('status') }}
        </div>
    @endif

    <a href="{{ route('admin.rooms.create') }}"
       style="display:inline-block; margin-bottom:20px; padding:10px 16px; background:#007BFF; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold;">
        + Add New Room
    </a>

    <table style="width:100%; border-collapse:collapse; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background:#2c3e50; color:#fff; text-align:left;">
                <th style="padding:12px;">Name</th>
                <th style="padding:12px;">Type</th>
                <th style="padding:12px;">Price</th>
                <th style="padding:12px;">Capacity</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr style="border-bottom:1px solid #ddd;">
                    <td style="padding:12px;">{{ $room->name }}</td>
                    <td style="padding:12px;">{{ $room->type }}</td>
                    <td style="padding:12px;">${{ number_format($room->price, 2) }}</td>
                    <td style="padding:12px;">{{ $room->capacity }}</td>
                    <td style="padding:12px;">
                        @if($room->active_bookings_count > 0)
                            <span style="color:#d9534f; font-weight:bold;">Booked</span>
                        @elseif(!$room->is_available)
                            <span style="color:#6c757d; font-weight:bold;">Unavailable</span>
                        @else
                            <span style="color:#28a745; font-weight:bold;">Available</span>
                        @endif
                    </td>
                    <td style="padding:12px;">
                        <a href="{{ route('admin.rooms.edit', $room->id) }}"
                           style="padding:6px 12px; background:#ffc107; color:#000; text-decoration:none; border-radius:4px; font-size:14px; margin-right:5px;">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.rooms.delete', $room->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this room?')"
                                    style="padding:6px 12px; background:#e3342f; color:#fff; border:none; border-radius:4px; font-size:14px; cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:15px; text-align:center; color:#666;">No rooms available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
