@extends('layouts.user.app')

@section('title', 'User Profile')

@section('header')
    User Profile
@endsection

@section('content')
<div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

    <h2 style="text-align:center; margin-bottom: 25px; color:#007BFF;">Update Your Profile</h2>

    @if(session('status'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('user.profile.update') }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="name" style="display:block; font-weight:bold; margin-bottom:5px;">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            @error('name')
                <div style="color:red; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="display:block; font-weight:bold; margin-bottom:5px;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            @error('email')
                <div style="color:red; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password" style="display:block; font-weight:bold; margin-bottom:5px;">New Password (leave blank to keep current):</label>
            <input type="password" name="password" id="password"
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            @error('password')
                <div style="color:red; margin-top:5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display:block; font-weight:bold; margin-bottom:5px;">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <div style="text-align:center;">
            <button type="submit" style="background-color:#007BFF; color:#fff; padding:10px 25px; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">
                Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
