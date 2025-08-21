@extends('layouts.main')

@section('title', 'Ticket #' . $ticket->id . ' - E-Ticketing System')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('tickets.index') }}" 
               class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to My Tickets
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Ticket Confirmation Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Ticket Confirmation</h1>
                        <p class="text-blue-100 mt-1">Your tickets have been confirmed</p>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-sm font-medium">Ticket #</div>
                        <div class="text-white text-xl font-bold">{{ $ticket->id }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Ticket Details -->
            <div class="p-6">
                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($ticket->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            @if($ticket->status === 'confirmed')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            @elseif($ticket->status === 'pending')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            @else
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
                
                <!-- Event Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Event Details -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h2>
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $ticket->event ? $ticket->event->name : 'Event not found' }}</h3>
                                </div>
                                
                                @if($ticket->event && $ticket->event->description)
                                    <div class="mt-4">
                                        <p class="text-gray-600">{{ $ticket->event->description }}</p>
                                    </div>
                                @endif
                                
                                <!-- Location -->
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Location</div>
                                        <div class="text-sm text-gray-600">{{ $ticket->event ? $ticket->event->location : 'N/A' }}</div>
                                    </div>
                                </div>
                                
                                <!-- Date & Time -->
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11m-6 0h8m-8 0V7a2 2 0 012-2h4a2 2 0 012 2v4"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Date & Time</div>
                                        <div class="text-sm text-gray-600">
                                            @if($ticket->event)
                                {{ \Carbon\Carbon::parse($ticket->event->start_date)->format('l, F j, Y') }}<br>
                                {{ \Carbon\Carbon::parse($ticket->event->start_date)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($ticket->event->end_date)->format('g:i A') }}
                            @else
                                N/A
                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Ticket Information -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ticket Information</h2>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-900">Buyer Name:</span>
                                    <span class="text-sm text-gray-600">{{ $ticket->buyer_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-900">Email:</span>
                                    <span class="text-sm text-gray-600">{{ $ticket->buyer_email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-900">Quantity:</span>
                                    <span class="text-sm text-gray-600">{{ $ticket->quantity }} {{ Str::plural('ticket', $ticket->quantity) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-900">Price per ticket:</span>
                                    <span class="text-sm text-gray-600">{{ $ticket->event ? 'RM ' . number_format($ticket->event->ticket_price, 2) : 'N/A' }}</span>
                                </div>
                                <hr class="border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                                    <span class="text-base font-semibold text-gray-900">{{ $ticket->event ? 'RM ' . number_format($ticket->event->ticket_price * $ticket->quantity, 2) : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-900">Purchase Date:</span>
                                    <span class="text-sm text-gray-600">{{ $ticket->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR Code Placeholder -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Entry QR Code</h2>
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <div class="w-32 h-32 bg-white border-2 border-dashed border-gray-300 rounded-lg mx-auto flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Show this QR code at the event entrance</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Important Information -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Important Information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Please arrive at least 30 minutes before the event starts</li>
                                    <li>Bring a valid ID that matches the name on this ticket</li>
                                    <li>This ticket is non-transferable and non-refundable</li>
                                    <li>Screenshots of this ticket will not be accepted at the venue</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button onclick="window.print()" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Ticket
                    </button>
                    <a href="{{ route('events.show', $ticket->event) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Event Details
                    </a>
                    <a href="{{ route('tickets.edit', $ticket) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Ticket
                    </a>
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Print functionality
        function printTicket() {
            window.print();
        }
    </script>
@endsection