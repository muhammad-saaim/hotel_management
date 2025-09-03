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
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            display: inline;
        }

        main {
            padding: 20px;
        }

        button {
            padding: 8px 15px;
            background: #e3342f;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            font-weight: bold;
        }

        button:hover {
            background: #cc1f1a;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
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
        <h1>@yield('header', 'Dashboard')</h1>
        <nav>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('user.profile') }}">Profile</a>
            <a href="{{ route('user.rooms') }}">Rooms</a>
            <a href="{{ route('user.bookings') }}">My Bookings</a>

            <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
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
