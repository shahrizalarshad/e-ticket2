@extends('layouts.main')

@section('title', $event->name . ' - E-Ticketing System')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('events.index') }}" 
               class="inline-flex items-center text-sm font-medium text-neutral-500 hover:text-neutral-700 transition-colors duration-200">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Events
            </a>
        </div>
        @auth
            @if(auth()->user()->isAdmin())
                <div class="flex items-center space-x-3">
                    <a href="{{ route('events.edit', $event) }}" 
                       class="inline-flex items-center px-3 py-2 border border-neutral-300 shadow-sm text-sm leading-4 font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Event
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Event Hero Section -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden mb-6">
                <!-- Event Image/Banner -->
                <div class="h-64 md:h-80 bg-gradient-to-r from-primary-600 via-accent-600 to-primary-700 relative">
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $event->name }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-white text-sm md:text-base opacity-90">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->location }}
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Event Details -->
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Main Content -->
                        <div class="xl:col-span-2">
                            <!-- Description -->
                            @if($event->description)
                                <div class="mb-8">
                                    <h2 class="text-xl font-semibold text-neutral-900 mb-4">About This Event</h2>
                                    <div class="prose prose-slate max-w-none">
                                        <p class="text-neutral-600 leading-relaxed">{{ $event->description }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Event Details Grid -->
                            <div class="mb-8">
                                <h2 class="text-xl font-semibold text-neutral-900 mb-4">Event Details</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                                    <!-- Start Date -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-success-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-4 w-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-neutral-900">Event Starts</h3>
                                            <p class="text-sm text-neutral-600">{{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y') }}</p>
                                            <p class="text-sm text-neutral-600">{{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- End Date -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-danger-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-4 w-4 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-neutral-900">Event Ends</h3>
                                            <p class="text-sm text-neutral-600">{{ \Carbon\Carbon::parse($event->end_date)->format('l, F j, Y') }}</p>
                                            <p class="text-sm text-neutral-600">{{ \Carbon\Carbon::parse($event->end_date)->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Location -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-neutral-900">Location</h3>
                                            <p class="text-sm text-neutral-600">{{ $event->location }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Capacity -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-accent-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-4 w-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-neutral-900">Capacity</h3>
                                            <p class="text-sm text-neutral-600">{{ number_format($event->capacity) }} attendees</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="xl:col-span-1">
                            <!-- Ticket Purchase Card -->
                            <div class="bg-neutral-50 rounded-xl border border-neutral-200 p-6 sticky top-6">
                                <div class="text-center mb-6">
                                    <div class="text-3xl font-bold text-neutral-900 mb-1">
                                        RM {{ number_format($event->ticket_price, 2) }}
                                    </div>
                                    <div class="text-sm text-neutral-500">per ticket</div>
                                </div>
                                
                                <!-- Availability Status -->
                                <div class="mb-6">
                                    @if($event->isVipAccessPeriod() && (!auth()->check() || !auth()->user()->isVip()))
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-neutral-600">Status</span>
                                            <span class="font-medium text-accent-600">VIP Only</span>
                                        </div>
                                        <div class="mt-2 bg-accent-100 rounded-full h-2">
                                            <div class="bg-accent-500 h-2 rounded-full" style="width: 100%"></div>
                                        </div>
                                        <div class="mt-1 text-xs text-accent-600">Available for regular customers after {{ $event->created_at->addHours(24)->format('M d, g:i A') }}</div>
                                    @else
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-neutral-600">Availability</span>
                                            <span class="font-medium text-success-600">Available</span>
                                        </div>
                                        <div class="mt-2 bg-neutral-200 rounded-full h-2">
                                            <div class="bg-success-500 h-2 rounded-full" style="width: {{ ($event->available_tickets / $event->capacity) * 100 }}%"></div>
                                        </div>
                                        <div class="mt-1 text-xs text-neutral-500">{{ $event->available_tickets }} / {{ $event->capacity }} tickets available</div>
                                    @endif
                                </div>
                                
                                <!-- Buy Ticket Button -->
                                @auth
                                    @if($event->canUserBook(auth()->user()))
                                        <a href="{{ route('tickets.create', $event) }}" 
                                           class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center inline-block">
                                            Purchase Tickets
                                        </a>
                                    @else
                                        <div class="w-full bg-accent-100 border border-accent-200 text-accent-800 font-medium py-3 px-6 rounded-lg text-center">
                                            <div class="flex items-center justify-center mb-2">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                VIP Only Period
                                            </div>
                                            <p class="text-sm">Available for regular customers after</p>
                                            <p class="text-sm font-semibold">{{ $event->created_at->addHours(24)->format('M d, Y g:i A') }}</p>
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center inline-block">
                                        Login to Purchase
                                    </a>
                                @endauth
                                
                                <!-- Additional Info -->
                                <div class="mt-4 text-xs text-neutral-500 text-center">
                                    <p>🔒 Secure payment processing</p>
                                    <p class="mt-1">📧 Instant email confirmation</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Add any additional JavaScript functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add smooth scrolling or other interactive features
        });
    </script>
@endsection
