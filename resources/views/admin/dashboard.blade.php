@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1>Admin Dashboard</h1>


<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">

    <a href="{{ route('admin.rooms.index') }}" style="flex:1; min-width:200px; background:#007BFF; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Total Rooms</h2>
        <p style="font-size:24px; font-weight:bold;">{{ $totalRooms }}</p>
    </a>

    <a href="{{ route('admin.rooms.index') }}" style="flex:1; min-width:200px; background:#28a745; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Available Rooms</h2>
        <p style="font-size:24px; font-weight:bold;">{{ $availableRooms }}</p>
    </a>

    <a href="{{ route('admin.bookings.index') }}" style="flex:1; min-width:200px; background:#ffc107; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Total Bookings</h2>
        <p style="font-size:24px; font-weight:bold;">{{ $totalBookings }}</p>
    </a>

    <a href="{{ route('admin.bookings.index') }}" style="flex:1; min-width:200px; background:#17a2b8; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Active Bookings</h2>
        <p style="font-size:24px; font-weight:bold;">{{ $activeBookings }}</p>
    </a>

    <a href="{{ route('admin.users.index') }}" style="flex:1; min-width:200px; background:#6c757d; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
    <h2>Total Users</h2>
    <p style="font-size:24px; font-weight:bold;">{{ $totalUsers }}</p>
</a>

</div>
@endsection
