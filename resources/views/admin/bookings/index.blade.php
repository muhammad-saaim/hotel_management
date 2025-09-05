@extends('admin.layouts.app')

@section('title', 'Bookings Management')
@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-size: 28px; font-weight: bold; margin-bottom: 20px; text-align:center;">Bookings Management</h2>

    @if(session('status'))
        <div style="background-color:#d4edda; color:#155724; padding:10px 15px; border-radius:5px; margin-bottom:20px; border:1px solid #c3e6cb;">
            {{ session('status') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.bookings.index') }}" style="margin-bottom: 25px; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
        <input type="text" name="user_name" placeholder="Search by User Name" value="{{ request('user_name') }}"
            style="padding:8px; border:1px solid #ccc; border-radius:4px; flex:1;">
        <input type="text" name="room_type" placeholder="Search by Room Type" value="{{ request('room_type') }}"
            style="padding:8px; border:1px solid #ccc; border-radius:4px; flex:1;">
        <input type="date" name="date" value="{{ request('date') }}"
            style="padding:8px; border:1px solid #ccc; border-radius:4px;">
        <button type="submit" style="padding:8px 15px; background:#007BFF; color:#fff; border:none; border-radius:4px; cursor:pointer;">Filter</button>
        <a href="{{ route('admin.bookings.index') }}" style="padding:8px 15px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none;">Reset</a>
    </form>

    @if($bookings->isEmpty())
        <p style="text-align:center; color:#555;">No bookings found.</p>
    @else
        <div style="overflow-x:auto; background:#fff; border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1); padding:10px;">
            <table style="width:100%; border-collapse:collapse; text-align:left;">
                <thead>
                    <tr style="background-color:#2c3e50; color:#fff;">
                        <th style="padding:10px; font-weight:600;">User</th>
                        <th style="padding:10px; font-weight:600;">Room</th>
                        <th style="padding:10px; font-weight:600;">Room Type</th>
                        <th style="padding:10px; font-weight:600;">Check-in</th>
                        <th style="padding:10px; font-weight:600;">Check-out</th>
                        <th style="padding:10px; font-weight:600;">Total Price</th>
                        <th style="padding:10px; font-weight:600;">Status</th>
                        <th style="padding:10px; font-weight:600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">{{ $booking->user->name }}<br><span style="color:#555; font-size:13px;">{{ $booking->user->email }}</span></td>
                            <td style="padding:10px;">{{ $booking->room->name }}</td>
                            <td style="padding:10px;">{{ $booking->room->type }}</td>
                            <td style="padding:10px;">{{ $booking->check_in->format('Y-m-d') }}</td>
                            <td style="padding:10px;">{{ $booking->check_out->format('Y-m-d') }}</td>
                            <td style="padding:10px;">${{ number_format($booking->total_price, 2) }}</td>
                            <td style="padding:10px;">
                                @if($booking->is_active)
                                    <span style="color: green; font-weight:bold;">Active</span>
                                @else
                                    <span style="color: red; font-weight:bold;">Expired</span>
                                @endif
                            </td>
                            <td style="padding:10px;">
                                <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:6px 12px; background:#e3342f; color:#fff; border:none; border-radius:4px; cursor:pointer;">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
