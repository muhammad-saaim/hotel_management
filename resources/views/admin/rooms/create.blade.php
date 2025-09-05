@extends('admin.layouts.app')

@section('title', 'Add New Room')
@section('content')
<h2>Add New Room</h2>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.rooms.store') }}">
    @csrf
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div>
        <label>Type:</label>
        <input type="text" name="type" value="{{ old('type') }}" required>
    </div>
    <div>
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
    </div>
    <div>
        <label>Capacity:</label>
        <input type="number" name="capacity" value="{{ old('capacity') }}" required>
    </div>
    <div>
        <label>Is Available:</label>
        <input type="checkbox" name="is_available" value="1" checked>
    </div>
    <button type="submit">Add Room</button>
</form>
@endsection
