@extends('layouts.user.app')

@section('title', 'Available Rooms')
@section('header', 'Available Rooms')

@section('content')
    @if(session('status'))
        <div style="background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px; font-weight:bold;">
            {{ session('status') }}
        </div>
    @endif

    @if($rooms->isEmpty())
        <p style="font-size:18px; color:#666;">No rooms available right now.</p>
    @else
        <div style="display:flex; flex-wrap:wrap; gap:25px;">
            @foreach($rooms as $room)
                <div style="flex:1 1 320px; background:#fff; border-radius:12px; box-shadow:0 8px 25px rgba(0,0,0,0.15); overflow:hidden; transition:transform 0.3s, box-shadow 0.3s; position:relative;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 14px 30px rgba(0,0,0,0.25)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';">

                    {{-- Room Image --}}
                    <div style="height:200px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; position:relative;">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span style="color:#aaa;">No Image</span>
                        @endif

                        {{-- Badges --}}
                        @if($loop->first)
                            <div style="position:absolute; top:10px; left:10px; background:#ffc107; color:#fff; padding:6px 12px; border-radius:5px; font-weight:bold; font-size:12px;">
                                ⭐ Popular
                            </div>
                        @elseif($loop->last)
                            <div style="position:absolute; top:10px; left:10px; background:#dc3545; color:#fff; padding:6px 12px; border-radius:5px; font-weight:bold; font-size:12px;">
                                🔥 Last Room
                            </div>
                        @else
                            <div style="position:absolute; top:10px; left:10px; background:#28a745; color:#fff; padding:6px 12px; border-radius:5px; font-weight:bold; font-size:12px;">
                                🆕 Available
                            </div>
                        @endif
                    </div>

                    {{-- Room Info --}}
                    <div style="padding:20px;">
                        <h3 style="margin:0 0 10px 0; color:#007BFF;">{{ $room->name }}</h3>
                        <p style="margin:0 0 5px 0;"><strong>Type:</strong> {{ $room->type }}</p>
                        <p style="margin:0 0 5px 0;"><strong>Capacity:</strong> {{ $room->capacity }} person(s)</p>

                        {{-- Features Example --}}
                        <div style="margin:10px 0;">
                            <span style="display:inline-block; margin-right:8px; font-size:13px; background:#f8f9fa; padding:5px 8px; border-radius:5px;">📶 Wi-Fi</span>
                            <span style="display:inline-block; margin-right:8px; font-size:13px; background:#f8f9fa; padding:5px 8px; border-radius:5px;">❄️ AC</span>
                            <span style="display:inline-block; margin-right:8px; font-size:13px; background:#f8f9fa; padding:5px 8px; border-radius:5px;">🥞 Breakfast</span>
                        </div>

                        <p style="margin:0 0 15px 0; font-size:20px; font-weight:bold; color:#28a745;">
                            ${{ number_format($room->price, 2) }} <span style="font-size:14px; color:#555;">/night</span>
                        </p>

                        {{-- Booking Form --}}
                        @if($room->is_available)
                            <form action="{{ route('user.rooms.book', $room->id) }}" method="POST" style="margin-top:15px;">
                                @csrf
                                <div style="margin-bottom:10px;">
                                    <label style="font-weight:bold;">Check-in:</label>
                                    <input type="date" name="check_in" min="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                                </div>
                                <div style="margin-bottom:15px;">
                                    <label style="font-weight:bold;">Check-out:</label>
                                    <input type="date" name="check_out" min="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                                </div>
                                <button type="submit"
                                        style="width:100%; padding:12px; background:#007BFF; color:white; border:none; border-radius:6px; font-weight:bold; transition:background 0.3s;"
                                        onmouseover="this.style.background='#0056b3';"
                                        onmouseout="this.style.background='#007BFF';">
                                    ✅ Book Now
                                </button>
                            </form>
                        @else
                            <button style="width:100%; padding:12px; background:#6c757d; color:white; border:none; border-radius:6px;" disabled>
                                Not Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
