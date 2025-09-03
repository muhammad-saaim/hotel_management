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

<form method="POST" action="{{ route('admin.rooms.update', $room->id) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $room->name) }}" required>
    </div>
    <div>
        <label>Type:</label>
        <input type="text" name="type" value="{{ old('type', $room->type) }}" required>
    </div>
    <div>
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $room->price) }}" required>
    </div>
    <div>
        <label>Capacity:</label>
        <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required>
    </div>
    <div>
        <label>Available:</label>
        <select name="is_available" required>
            <option value="1" {{ $room->is_available ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$room->is_available ? 'selected' : '' }}>No</option>
        </select>
    </div>
    <button type="submit">Update Room</button>
</form>
@endsection
