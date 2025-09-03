@extends('admin.layouts.app')

@section('title', 'Bookings Management')
@section('content')
<h2>All Bookings</h2>

@if(session('status'))
    <div style="color: green; margin-bottom: 15px;">{{ session('status') }}</div>
@endif

{{-- Filter Form --}}
<form method="GET" action="{{ route('admin.bookings.index') }}" style="margin-bottom: 20px;">
    <input type="text" name="user_name" placeholder="Search by User Name" value="{{ request('user_name') }}" style="padding:5px; margin-right:5px;">
    <input type="text" name="room_type" placeholder="Search by Room Type" value="{{ request('room_type') }}" style="padding:5px; margin-right:5px;">
    <input type="date" name="date" value="{{ request('date') }}" style="padding:5px; margin-right:5px;">
    <button type="submit" style="padding:5px 10px; background:#007BFF; color:#fff; border:none; border-radius:3px;">Filter</button>
    <a href="{{ route('admin.bookings.index') }}" style="padding:5px 10px; background:#6c757d; color:#fff; border-radius:3px; text-decoration:none;">Reset</a>
</form>

@if($bookings->isEmpty())
    <p>No bookings found.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#fff; border-collapse:collapse;">
        <thead>
            <tr>
                <th>User</th>
                <th>Room</th>
                <th>Room Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }} ({{ $booking->user->email }})</td>
                    <td>{{ $booking->room->name }}</td>
                    <td>{{ $booking->room->type }}</td>
                    <td>{{ $booking->check_in->format('Y-m-d') }}</td>
                    <td>{{ $booking->check_out->format('Y-m-d') }}</td>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        @if($booking->is_active)
                            <span style="color: green; font-weight:bold;">Active</span>
                        @else
                            <span style="color: red; font-weight:bold;">Expired</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding:5px 10px; background:#e3342f; color:#fff; border:none; border-radius:3px;">Cancel</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
