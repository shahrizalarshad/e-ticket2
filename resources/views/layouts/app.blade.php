<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticketing System</title>
</head>
<body>
    <div>
        <header>
            <h1>E-Ticketing System</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('tickets.index') }}">Tickets</a></li>
                    {{-- @if (Auth::check())
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif --}}
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} E-Ticketing System</p>
        </footer>
    </div>

</body>
</html>
