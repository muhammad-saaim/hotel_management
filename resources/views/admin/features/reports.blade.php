@extends('admin.layouts.app')

@section('title', 'Booking Reports')

@section('content')
<h1>Booking Reports</h1>

<form method="GET" action="{{ route('admin.features.reports') }}" style="margin-bottom:20px;">
    <input type="date" name="from_date" value="{{ request('from_date') }}" style="padding:5px; margin-right:5px;">
    <input type="date" name="to_date" value="{{ request('to_date') }}" style="padding:5px; margin-right:5px;">
    <button type="submit" style="padding:5px 10px; background:#007BFF; color:#fff; border:none; border-radius:3px;">Filter</button>
    <a href="{{ route('admin.features.reports') }}" style="padding:5px 10px; background:#6c757d; color:#fff; border-radius:3px; text-decoration:none;">Reset</a>
</form>

@if($bookings->isEmpty())
    <p>No bookings found.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse; background:#fff;">
        <thead>
            <tr>
                <th>User</th>
                <th>Room</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }} ({{ $booking->user->email }})</td>
                    <td>{{ $booking->room->name }}</td>
                    <td>{{ $booking->check_in->format('Y-m-d') }}</td>
                    <td>{{ $booking->check_out->format('Y-m-d') }}</td>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
