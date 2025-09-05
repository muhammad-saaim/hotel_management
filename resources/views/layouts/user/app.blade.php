<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Dashboard')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }

        header {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            flex: 1; /* equal width for left & right */
        }

        .header-left {
            justify-content: flex-start;
        }

        .header-right {
            justify-content: flex-end;
        }

        .logo img {
            height: 60px;
        }

        .hotel-name {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            flex: 0;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 20px; /* ✅ space between links */
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        nav form {
            display: inline-flex;
            margin: 0;
            padding: 0;
        }

        .logout-btn button {
            background: #e3342f;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s ease-in-out;
        }

        .logout-btn button:hover {
            background: #c82333;
        }

        main {
            padding: 20px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <header>
        {{-- Left: Logo --}}
        <div class="header-left">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Hotel Logo">
            </div>
        </div>

        {{-- Center: Hotel Name --}}
        <div class="hotel-name">
            <a href="{{ route('dashboard') }}" style="color:white; text-decoration:none;">
                Mariott Hotel
            </a>
        </div>

        {{-- Right: Nav --}}
        <div class="header-right">
            <nav>
                <a href="{{ route('dashboard') }}">Home</a>
                <a href="{{ route('user.rooms') }}">Rooms</a>
                <a href="{{ route('user.bookings') }}">My Bookings</a>
                <a href="{{ route('user.profile') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main>
        @if(session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
