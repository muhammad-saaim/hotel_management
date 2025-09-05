@extends('admin.layouts.app')

@section('title', 'Edit Room')
@section('content')
<h2>Edit Room: {{ $room->name }}</h2>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $room->name) }}" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Type:</label>
        <input type="text" name="type" value="{{ old('type', $room->type) }}" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $room->price) }}" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Capacity:</label>
        <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Available:</label>
        <select name="is_available" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            <option value="1" {{ $room->is_available ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$room->is_available ? 'selected' : '' }}>No</option>
        </select>
    </div>

    {{-- Current Image --}}
    @if($room->image)
        <div style="margin-bottom:15px;">
            <label>Current Image:</label><br>
            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width:150px; height:auto; border:1px solid #ccc; padding:3px; border-radius:4px;">
        </div>
    @endif

    {{-- Upload New Image --}}
    <div style="margin-bottom:20px;">
        <label>Upload New Image (optional):</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <button type="submit" style="padding:10px 20px; background:#2c3e50; color:#fff; border:none; border-radius:5px; cursor:pointer;">
        Update Room
    </button>
</form>
@endsection
