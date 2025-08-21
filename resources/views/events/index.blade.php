@extends('layouts.main')

@section('title', 'Events - E-Ticketing System')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Upcoming Events</h1>
            <p class="mt-2 text-sm text-gray-600">Discover amazing events and book your tickets</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin())
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('events.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Event
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($events->count() > 0)
            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200">
                        <!-- Event Image Placeholder -->
                        <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-xl font-bold text-white mb-1 line-clamp-2">{{ $event->name }}</h3>
                                <div class="flex items-center text-white text-sm opacity-90">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Details -->
                        <div class="p-6">
                            <!-- Date and Time -->
                            <div class="flex items-center mb-4 text-sm text-gray-600">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y • g:i A') }}</span>
                            </div>
                            
                            <!-- Description -->
                            @if($event->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $event->description }}</p>
                            @endif
                            
                            <!-- Event Stats -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    @if($event->isVipAccessPeriod() && (!auth()->check() || !auth()->user()->isVip()))
                                        <div class="flex items-center text-purple-600">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            VIP Only Period
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            Available {{ $event->created_at->addHours(24)->format('M d, g:i A') }}
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $event->available_tickets }} / {{ $event->capacity }} available
                                        </div>
                                        @if($event->isVipAccessPeriod())
                                            <div class="flex items-center text-purple-600">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                VIP Access
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">RM {{ number_format($event->ticket_price, 2) }}</div>
                                    <div class="text-xs text-gray-500">per ticket</div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    View Details
                                </a>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <div class="flex space-x-1">
                                            <a href="{{ route('events.edit', $event) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                               title="Edit Event">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this event?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                                        title="Delete Event">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-full w-full">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No events found</h3>
                <p class="mt-2 text-sm text-gray-500">Get started by creating your first event.</p>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="mt-6">
                            <a href="{{ route('events.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create Your First Event
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        @endif
    </div>
@endsection
