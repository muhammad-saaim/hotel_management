@extends('admin.layouts.app')

@section('title', 'Admin Features')

@section('content')
<h1>Admin Features</h1>

<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">
    <a href="{{ route('admin.bookings.index') }}" style="flex:1; min-width:200px; background:#007BFF; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        Total Bookings: {{ $totalBookings }}
    </a>
    <a href="{{ route('admin.rooms.index') }}" style="flex:1; min-width:200px; background:#28a745; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        Total Rooms: {{ $totalRooms }}
    </a>
    <a href="{{ route('admin.users.index') }}" style="flex:1; min-width:200px; background:#ffc107; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        Total Users: {{ $totalUsers }}
    </a>
    <a href="{{ route('admin.features.reports') }}" style="flex:1; min-width:200px; background:#17a2b8; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        View Reports
    </a>
</div>
@endsection
