<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin Dashboard')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f4f5f7;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 0;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 5px;
        }

        /* Main content */
        .content {
            flex: 1;
            padding: 40px;
        }

        .logout-btn button {
            padding: 10px 20px;
            background-color: #e3342f;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn button:hover {
            background-color: #cc1f1a;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.rooms.index') }}">Rooms</a>
        <a href="{{ route('admin.bookings.index') }}">Bookings</a>
        <a href="{{ route('admin.features.index') }}">Features</a>
        <a href="{{ route('admin.features.reports') }}">Reports</a>

        <div class="logout-btn" style="margin-top: 20px;">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
