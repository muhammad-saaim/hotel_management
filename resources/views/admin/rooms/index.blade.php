@extends('admin.layouts.app')

@section('title', 'Rooms Management')
@section('content')
<h2>All Rooms</h2>

@if(session('status'))
    <div style="color: green; margin-bottom: 15px;">{{ session('status') }}</div>
@endif

<a href="{{ route('admin.rooms.create') }}" style="display:inline-block; margin-bottom:15px; padding:8px 12px; background:#007BFF; color:#fff; text-decoration:none; border-radius:3px;">
    Add New Room
</a>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#fff; border-collapse:collapse;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->name }}</td>
                <td>{{ $room->type }}</td>
                <td>${{ number_format($room->price, 2) }}</td>
                <td>{{ $room->capacity }}</td>
                <td>
                    @if($room->active_bookings_count > 0)
                        Booked
                    @elseif(!$room->is_available)
                        Unavailable
                    @else
                        Available
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" style="margin-right:5px;">Edit</a>
                    <form method="POST" action="{{ route('admin.rooms.delete', $room->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this room?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
