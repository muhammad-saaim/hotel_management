@extends('layouts.user.app')

@section('title', 'Home')
@section('header', 'Welcome to Mariott Hotel')

@section('content')
<div style="max-width:1200px; margin:0 auto; padding:20px;">

    {{-- Quick Access Cards --}}
    <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:25px; justify-content:center;">
        <a href="{{ route('user.rooms') }}"
           style="flex:1 1 200px; min-width:200px; background:#007BFF; color:#fff; padding:30px; border-radius:12px; text-decoration:none; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:transform 0.2s;">
            <h2 style="margin:0; font-size:24px; font-weight:bold;">Rooms</h2>
            <p style="font-size:18px; margin-top:10px;">View & Book</p>
        </a>

        <a href="{{ route('user.bookings') }}"
           style="flex:1 1 200px; min-width:200px; background:#28a745; color:#fff; padding:30px; border-radius:12px; text-decoration:none; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:transform 0.2s;">
            <h2 style="margin:0; font-size:24px; font-weight:bold;">My Bookings</h2>
            <p style="font-size:18px; margin-top:10px;">Check Status</p>
        </a>

        <a href="{{ route('user.profile') }}"
           style="flex:1 1 200px; min-width:200px; background:#ffc107; color:#fff; padding:30px; border-radius:12px; text-decoration:none; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition:transform 0.2s;">
            <h2 style="margin:0; font-size:24px; font-weight:bold;">Profile</h2>
            <p style="font-size:18px; margin-top:10px;">Manage Info</p>
        </a>
    </div>

    {{-- Featured Rooms Section --}}
    @if($rooms && $rooms->isNotEmpty())
        <h3 style="margin-top:50px; color:#007BFF; font-size:24px; font-weight:bold;">Featured Rooms</h3>
        <div style="display:flex; flex-wrap:wrap; gap:20px; margin-top:20px; justify-content:center;">
            @foreach($rooms->take(3) as $room)
                <div style="flex:1 1 300px; max-width:300px; background:#fff; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.12); overflow:hidden; transition:transform 0.2s;">
                    <div style="height:180px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span style="color:#aaa;">No Image</span>
                        @endif
                    </div>
                    <div style="padding:15px;">
                        <h4 style="margin:0 0 8px 0; color:#007BFF; font-size:20px; font-weight:bold;">{{ $room->name }}</h4>
                        <p style="margin:0; font-size:14px; color:#555;">Type: {{ $room->type }} | Capacity: {{ $room->capacity }}</p>
                        <p style="margin:10px 0 0 0; font-size:16px; font-weight:bold; color:#28a745;">
                            ${{ number_format($room->price, 2) }} / night
                        </p>
                        @if($room->is_available)
                            <a href="{{ route('user.rooms') }}"
                               style="display:inline-block; margin-top:12px; padding:10px 15px; background:#007BFF; color:white; border-radius:6px; text-decoration:none; font-weight:bold; text-align:center;">
                               Book Now
                            </a>
                        @else
                            <span style="display:inline-block; margin-top:12px; padding:10px 15px; background:#6c757d; color:white; border-radius:6px; font-weight:bold; text-align:center;">
                               Not Available
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Hover Effects --}}
<style>
    a:hover {
        transform: translateY(-3px);
    }
    div[style*="box-shadow"]:hover {
        transform: translateY(-5px);
        box-shadow:0 12px 25px rgba(0,0,0,0.15);
    }
</style>
@endsection
