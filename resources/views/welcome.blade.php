<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-neutral-100 selection:bg-primary-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-neutral-600 hover:text-neutral-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-neutral-600 hover:text-neutral-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-neutral-600 hover:text-neutral-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-6xl font-bold text-neutral-900">E-Ticket System</h1>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="{{ route('events.index') }}" class="scale-100 p-6 bg-white from-neutral-700/50 via-transparent rounded-lg shadow-2xl shadow-neutral-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-primary-500">
                            <div>
                                <h2 class="text-xl font-semibold text-neutral-900">Browse Events</h2>
                                <p class="mt-4 text-neutral-500 text-sm leading-relaxed">
                                    Discover amazing events happening near you. From conferences to concerts, find your next experience.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('tickets.index') }}" class="scale-100 p-6 bg-white from-neutral-700/50 via-transparent rounded-lg shadow-2xl shadow-neutral-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-primary-500">
                            <div>
                                <h2 class="text-xl font-semibold text-neutral-900">My Tickets</h2>
                                <p class="mt-4 text-neutral-500 text-sm leading-relaxed">
                                    View and manage your purchased tickets. Access your QR codes and event details.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>