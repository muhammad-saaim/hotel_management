@extends('layouts.user.app')

@section('title', 'Home')
@section('header', 'Welcome to Mariott Hotel')

@section('content')
   

    <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:25px;">

        {{-- Quick Access Cards --}}
        <a href="{{ route('user.rooms') }}"
           style="flex:1; min-width:200px; background:#007BFF; color:#fff; padding:25px; border-radius:10px; text-decoration:none; text-align:center;">
            <h2>Rooms</h2>
            <p style="font-size:20px; font-weight:bold;">View & Book</p>
        </a>

        <a href="{{ route('user.bookings') }}"
           style="flex:1; min-width:200px; background:#28a745; color:#fff; padding:25px; border-radius:10px; text-decoration:none; text-align:center;">
            <h2>My Bookings</h2>
            <p style="font-size:20px; font-weight:bold;">Check Status</p>
        </a>

        <a href="{{ route('user.profile') }}"
           style="flex:1; min-width:200px; background:#ffc107; color:#fff; padding:25px; border-radius:10px; text-decoration:none; text-align:center;">
            <h2>Profile</h2>
            <p style="font-size:20px; font-weight:bold;">Manage Info</p>
        </a>

    </div>

    {{-- Optional Featured Rooms Section --}}
    @if($rooms && $rooms->isNotEmpty())
        <h3 style="margin-top:40px; color:#007BFF;">Featured Rooms</h3>
        <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:15px;">
            @foreach($rooms->take(3) as $room)
                <div style="flex:1 1 300px; background:#fff; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.12); overflow:hidden;">
                    <div style="height:150px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span style="color:#aaa;">No Image</span>
                        @endif
                    </div>
                    <div style="padding:15px;">
                        <h4 style="margin:0 0 5px 0; color:#007BFF;">{{ $room->name }}</h4>
                        <p style="margin:0; font-size:14px; color:#555;">Type: {{ $room->type }} | Capacity: {{ $room->capacity }}</p>
                        <p style="margin:10px 0 0 0; font-size:16px; font-weight:bold; color:#28a745;">
                            ${{ number_format($room->price, 2) }} / night
                        </p>
                        @if($room->is_available)
                            <a href="{{ route('user.rooms') }}"
                               style="display:inline-block; margin-top:10px; padding:8px 12px; background:#007BFF; color:white; border-radius:5px; text-decoration:none;">
                               Book Now
                            </a>
                        @else
                            <span style="display:inline-block; margin-top:10px; padding:8px 12px; background:#6c757d; color:white; border-radius:5px;">
                               Not Available
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
