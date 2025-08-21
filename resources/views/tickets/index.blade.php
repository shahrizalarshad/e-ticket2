@extends('layouts.main')

@section('title', 'My Tickets - E-Ticketing System')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Tickets</h1>
            <p class="mt-2 text-sm text-gray-600">View and manage your purchased tickets</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($tickets->count() > 0)
            <!-- Tickets List -->
            <div class="space-y-6">
                @foreach ($tickets as $ticket)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Ticket Info -->
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- Event Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Event Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                {{ $ticket->event ? $ticket->event->name : 'Event not found' }}
                                            </h3>
                                            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $ticket->event ? $ticket->event->location : 'N/A' }}
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0h8m-8 0V7a2 2 0 012-2h4a2 2 0 012 2v4"/>
                                    </svg>
                                    {{ $ticket->event ? \Carbon\Carbon::parse($ticket->event->start_date)->format('M d, Y - g:i A') : 'N/A' }}
                                </div>
                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ticket Details -->
                                <div class="mt-4 lg:mt-0 lg:ml-6">
                                    <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-start sm:items-center lg:items-end xl:items-center space-y-2 sm:space-y-0 sm:space-x-4 lg:space-x-0 lg:space-y-2 xl:space-y-0 xl:space-x-4">
                                        <!-- Quantity & Status -->
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $ticket->quantity }} {{ Str::plural('Ticket', $ticket->quantity) }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Ticket #{{ $ticket->id }}
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($ticket->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('tickets.show', $ticket) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                View Details
                                            </a>
                                            
                                            @if($ticket->status === 'confirmed' && !$ticket->event->hasPassed() && (auth()->user()->id === $ticket->user_id || auth()->user()->isAdmin()))
                                                <form action="{{ route('tickets.cancel', $ticket) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('Are you sure you want to cancel this ticket? This action cannot be undone.')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-2 border border-orange-300 shadow-sm text-sm leading-4 font-medium rounded-md text-orange-700 bg-white hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                                                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('tickets.edit', $ticket) }}" 
                                                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                            @endif
                                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-24 w-24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No tickets found</h3>
                <p class="mt-2 text-sm text-gray-500">You haven't purchased any tickets yet.</p>
                <div class="mt-6">
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Browse Events
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection