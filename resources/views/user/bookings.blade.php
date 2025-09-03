@extends('layouts.user.app')

@section('title', 'My Bookings')
@section('header', 'My Bookings')

@section('content')
    @if(session('status'))
        <div style="background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px; font-weight:bold;">
            {{ session('status') }}
        </div>
    @endif

    @if($bookings->isEmpty())
        <p style="font-size:18px; color:#666;">You have no bookings yet.</p>
    @else
        <div style="display:flex; flex-wrap:wrap; gap:25px;">
            @foreach($bookings as $booking)
                @php
                    $today = \Carbon\Carbon::today();
                    $checkIn = \Carbon\Carbon::parse($booking->check_in);
                    $checkOut = \Carbon\Carbon::parse($booking->check_out);
                    $totalNights = $checkIn->diffInDays($checkOut);

                    if ($checkOut->isPast()) {
                        $status = 'Completed';
                        $statusColor = '#6c757d';
                    } elseif ($checkOut->diffInDays($today) <= 2) {
                        $status = 'Expiring Soon';
                        $statusColor = '#fd7e14'; // orange
                    } else {
                        $status = 'Active';
                        $statusColor = '#17a2b8';
                    }
                @endphp

                <div style="flex:1 1 300px; background:#fff; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.12); overflow:hidden; transition:transform 0.3s;">
                    <div style="padding:20px;">
                        <h3 style="margin:0 0 10px 0; color:#007BFF;">{{ $booking->room->name }}</h3>
                        <p style="margin:0 0 5px 0;"><strong>Type:</strong> {{ $booking->room->type }}</p>
                        <p style="margin:0 0 5px 0;"><strong>Capacity:</strong> {{ $booking->room->capacity }} person(s)</p>
                        <p style="margin:0 0 5px 0;"><strong>Check-in:</strong> {{ $checkIn->format('M d, Y') }}</p>
                        <p style="margin:0 0 5px 0;"><strong>Check-out:</strong> {{ $checkOut->format('M d, Y') }}</p>
                        <p style="margin:0 0 5px 0;"><strong>Total Nights:</strong> {{ $totalNights }}</p>
                        <p style="margin:0 0 15px 0; font-size:18px; font-weight:bold; color:#28a745;">
                            ${{ number_format($booking->total_price, 2) }}
                        </p>

                        <span style="display:inline-block; padding:5px 10px; border-radius:5px; background:{{ $statusColor }}; color:white; font-weight:bold; margin-bottom:10px;">
                            {{ $status }}
                        </span>

                        @if($status === 'Active' || $status === 'Expiring Soon')
                            <form method="POST" action="{{ route('user.bookings.cancel', $booking->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width:100%; padding:10px; background:#dc3545; color:white; border:none; border-radius:5px; font-weight:bold;" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        @else
                            <button style="width:100%; padding:10px; background:#6c757d; color:white; border:none; border-radius:5px;" disabled>
                                Completed
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
