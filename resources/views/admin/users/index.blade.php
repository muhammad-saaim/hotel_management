@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')
<h2>All Users</h2>

@if(session('status'))
    <div style="color: green; margin-bottom: 15px;">{{ session('status') }}</div>
@endif

{{-- Search Form --}}
<form method="GET" action="{{ route('admin.users.index') }}" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search by name or email"
           value="{{ request('search') }}" style="padding:5px; margin-right:5px;">
    <button type="submit" style="padding:5px 10px; background:#007BFF; color:#fff; border:none; border-radius:3px;">
        Search
    </button>
    <a href="{{ route('admin.users.index') }}"
       style="padding:5px 10px; background:#6c757d; color:#fff; border-radius:3px; text-decoration:none;">
       Reset
    </a>
</form>

@if($users->isEmpty())
    <p>No users found.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0"
           style="width:100%; background:#fff; border-collapse:collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" style="margin-right:5px;">Edit</a>
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this user?')"
                                    style="padding:5px 10px; background:#e3342f; color:#fff; border:none; border-radius:3px;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
