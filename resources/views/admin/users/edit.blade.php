@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<h2>Edit User</h2>

@if($errors->any())
    <div style="color:red; margin-bottom:10px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" style="max-width:500px;">
    @csrf
    @method('PUT')

    <div class="form-group" style="margin-bottom:15px;">
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}" required
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:3px;">
    </div>

    <div class="form-group" style="margin-bottom:15px;">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:3px;">
    </div>

    <div class="form-group" style="margin-bottom:15px;">
        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:3px;">
    </div>

    <div class="form-group" style="margin-bottom:15px;">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:3px;">
    </div>

    <button type="submit" style="padding:10px 20px; background:#007BFF; color:#fff; border:none; border-radius:3px;">
        Update User
    </button>
    <a href="{{ route('admin.users.index') }}" style="padding:10px 20px; background:#6c757d; color:#fff; border-radius:3px; text-decoration:none; margin-left:10px;">
        Cancel
    </a>
</form>
@endsection
