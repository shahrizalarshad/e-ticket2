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
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gradient-to-br from-primary-50 via-neutral-50 to-neutral-100 bg-center selection:bg-primary-500 selection:text-white">
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
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-600 to-primary-700 p-8 md:p-12 shadow-lg">
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-primary-300 to-primary-700"></div>
                    <div class="relative z-10 text-center">
                        <h1 class="text-4xl md:text-6xl font-bold text-white drop-shadow-sm">Discover Events & Book Tickets</h1>
                        <p class="mt-4 text-primary-100">Concerts, conferences, workshops, sports, theater, and more — all in one place.</p>
                    </div>
                    <!-- Modern Search Bar -->
                    <form method="GET" action="{{ route('events.index') }}" class="relative z-10 mt-8">
                        <div class="flex flex-col md:flex-row gap-3 bg-white/90 backdrop-blur rounded-xl p-3 shadow">
                            <div class="flex-1">
                                <label for="q" class="sr-only">Search events</label>
                                <input id="q" name="q" type="text" placeholder="Search events, venues, or keywords" class="w-full rounded-md border-neutral-300 focus:border-primary-500 focus:ring-primary-500" />
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center text-sm text-neutral-800 bg-neutral-100 px-3 py-2 rounded-md">
                                    <input type="checkbox" name="upcoming" value="1" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2">Upcoming only</span>
                                </label>
                                <label class="inline-flex items-center text-sm text-neutral-800 bg-neutral-100 px-3 py-2 rounded-md">
                                    <input type="checkbox" name="free" value="1" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2">Free</span>
                                </label>
                            </div>
                            <button type="submit" class="inline-flex items-center px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Search</button>
                        </div>
                    </form>
                    <!-- Category Chips -->
                    <div class="relative z-10 mt-4 flex flex-wrap items-center justify-center gap-2">
                        @php($categories = ['Concerts','Conferences','Workshops','Sports','Theater','Festivals','Meetups','Comedy'])
                        @foreach($categories as $cat)
                            <a href="{{ route('events.index', ['q' => strtolower($cat)]) }}" class="text-sm bg-primary-50 hover:bg-primary-100 text-primary-700 px-3 py-1.5 rounded-full">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mt-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="{{ route('events.index') }}" class="scale-100 p-6 bg-white rounded-lg shadow-md flex motion-safe:hover:scale-[1.01] transition-all duration-200 focus:outline focus:outline-2 focus:outline-primary-500">
                            <div>
                                <h2 class="text-xl font-semibold text-neutral-900">Browse Events</h2>
                                <p class="mt-2 text-neutral-600 text-sm leading-relaxed">
                                    Discover amazing events happening near you. From conferences to concerts, find your next experience.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('tickets.index') }}" class="scale-100 p-6 bg-white rounded-lg shadow-md flex motion-safe:hover:scale-[1.01] transition-all duration-200 focus:outline focus:outline-2 focus:outline-primary-500">
                            <div>
                                <h2 class="text-xl font-semibold text-neutral-900">My Tickets</h2>
                                <p class="mt-2 text-neutral-600 text-sm leading-relaxed">
                                    View and manage your purchased tickets. Access your QR codes and event details.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Featured Upcoming Events -->
                @if(isset($featuredEvents) && $featuredEvents->isNotEmpty())
                    <div class="mt-12">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-semibold text-neutral-900">Featured Upcoming Events</h2>
                            <a href="{{ route('events.index') }}" class="text-sm text-primary-600 hover:text-primary-700">See all events</a>
                        </div>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($featuredEvents as $event)
                                <div class="p-6 bg-white shadow rounded-xl ring-1 ring-neutral-200 flex flex-col justify-between">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-neutral-900">{{ $event->name }}</h3>
                                            <p class="mt-1 text-sm text-neutral-600">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }} @if($event->location) · {{ $event->location }} @endif</p>
                                        </div>
                                        <div class="space-x-2">
                                            @if($event->isVipAccessPeriod())
                                                <span class="inline-flex items-center text-xs font-medium text-amber-700 bg-amber-100 rounded-full px-2 py-0.5">VIP Access</span>
                                            @endif
                                            @if(($event->ticket_price ?? 0) == 0)
                                                <span class="inline-flex items-center text-xs font-medium text-green-700 bg-green-100 rounded-full px-2 py-0.5">Free</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-neutral-900 font-bold">
                                            @if($event->ticket_price === null || $event->ticket_price == 0)
                                                Free
                                            @else
                                                RM {{ number_format($event->ticket_price, 2) }}
                                            @endif
                                        </div>
                                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Latest Events -->
                @if(isset($latestEvents) && $latestEvents->isNotEmpty())
                    <div class="mt-12">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-semibold text-neutral-900">Latest Events</h2>
                            @if(isset($trendingLocations) && $trendingLocations->isNotEmpty())
                                <div class="hidden md:flex items-center gap-2">
                                    @foreach($trendingLocations as $loc)
                                        <a href="{{ route('events.index', ['location' => $loc]) }}" class="text-xs bg-neutral-100 hover:bg-neutral-200 text-neutral-800 px-2.5 py-1 rounded-full">{{ $loc }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                            @foreach($latestEvents as $event)
                                <div class="p-4 bg-white shadow rounded-xl ring-1 ring-neutral-200">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-md font-medium text-neutral-900">{{ $event->name }}</h3>
                                            <p class="mt-1 text-xs text-neutral-600">{{ $event->location }}</p>
                                        </div>
                                        @if(($event->ticket_price ?? 0) == 0)
                                            <span class="inline-flex items-center text-xs font-medium text-green-700 bg-green-100 rounded-full px-2 py-0.5">Free</span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm text-neutral-700">@if($event->ticket_price === null || $event->ticket_price == 0) Free @else RM {{ number_format($event->ticket_price, 2) }} @endif</p>
                                    <a href="{{ route('events.show', $event) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-900 rounded-md text-sm">Details</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Organizer CTA -->
                <div class="mt-16 text-center">
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Create an Event</a>
                    @else
                        <p class="text-neutral-700">Are you an organizer? <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">Log in</a> or <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700">register</a> to create events.</p>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
