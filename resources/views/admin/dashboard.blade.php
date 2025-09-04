@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1>Admin Dashboard</h1>

<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">

    <a href="{{ route('admin.rooms.index') }}" id="totalRoomsCard"
       style="flex:1; min-width:200px; background:#007BFF; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Total Rooms</h2>
        <p style="font-size:24px; font-weight:bold;">0</p>
    </a>

    <a href="{{ route('admin.rooms.index') }}" id="availableRoomsCard"
       style="flex:1; min-width:200px; background:#28a745; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Available Rooms</h2>
        <p style="font-size:24px; font-weight:bold;">0</p>
    </a>

    <a href="{{ route('admin.bookings.index') }}" id="totalBookingsCard"
       style="flex:1; min-width:200px; background:#ffc107; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Total Bookings</h2>
        <p style="font-size:24px; font-weight:bold;">0</p>
    </a>

    <a href="{{ route('admin.bookings.index') }}" id="activeBookingsCard"
       style="flex:1; min-width:200px; background:#17a2b8; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Active Bookings</h2>
        <p style="font-size:24px; font-weight:bold;">0</p>
    </a>

    <a href="{{ route('admin.users.index') }}" id="totalUsersCard"
       style="flex:1; min-width:200px; background:#6c757d; color:#fff; padding:20px; border-radius:5px; text-decoration:none;">
        <h2>Total Users</h2>
        <p style="font-size:24px; font-weight:bold;">0</p>
    </a>

</div>

{{-- AJAX Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    function fetchStats() {
        fetch('{{ route("admin.dashboard.stats") }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('#totalRoomsCard p').textContent = data.totalRooms;
                document.querySelector('#availableRoomsCard p').textContent = data.availableRooms;
                document.querySelector('#totalBookingsCard p').textContent = data.totalBookings;
                document.querySelector('#activeBookingsCard p').textContent = data.activeBookings;
                document.querySelector('#totalUsersCard p').textContent = data.totalUsers;
            })
            .catch(err => console.error('Error fetching dashboard stats:', err));
    }

    // Initial fetch
    fetchStats();

    // Refresh every 5 seconds
    setInterval(fetchStats, 5000);
});
</script>
@endsection
