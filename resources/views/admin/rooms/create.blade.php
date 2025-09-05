@extends('admin.layouts.app')

@section('title', 'Add New Room')
@section('content')
<div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px; text-align: center;">Add New Room</h2>

    @if ($errors->any())
        <div style="background-color: #ffe6e6; border: 1px solid #ff4d4d; color: #a70000; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.rooms.store') }}">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="name" style="display:block; font-weight: bold; margin-bottom: 5px;">Room Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="type" style="display:block; font-weight: bold; margin-bottom: 5px;">Room Type:</label>
            <input type="text" id="type" name="type" value="{{ old('type') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="price" style="display:block; font-weight: bold; margin-bottom: 5px;">Price ($):</label>
            <input type="number" id="price" step="0.01" name="price" value="{{ old('price') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="capacity" style="display:block; font-weight: bold; margin-bottom: 5px;">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <input type="hidden" name="is_available" value="0">
            <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', 1) ? 'checked' : '' }}>
            <label for="is_available" style="font-weight: bold;">Room Available</label>
        </div>

        <div style="text-align: center;">
            <button type="submit" style="background-color: #2c3e50; color: #fff; padding: 10px 25px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                Add Room
            </button>
        </div>
    </form>
</div>
@endsection
