@extends('layouts.main')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Ticket #') . $ticket->id }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Event Information -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Event Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Event:</span>
                                <span class="ml-2">{{ $ticket->event ? $ticket->event->name : 'Event not found' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Location:</span>
                                <span class="ml-2">{{ $ticket->event ? $ticket->event->location : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Date & Time:</span>
                                <span class="ml-2">{{ $ticket->event ? \Carbon\Carbon::parse($ticket->event->start_date)->format('M d, Y • g:i A') : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Price per ticket:</span>
                                <span class="ml-2">{{ $ticket->event ? 'RM ' . number_format($ticket->event->ticket_price, 2) : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Buyer Name -->
                        <div>
                            <label for="buyer_name" class="block text-sm font-medium text-gray-700">Buyer Name</label>
                            <input type="text" name="buyer_name" id="buyer_name" value="{{ old('buyer_name', $ticket->buyer_name) }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('buyer_name')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buyer Email -->
                        <div>
                            <label for="buyer_email" class="block text-sm font-medium text-gray-700">Buyer Email</label>
                            <input type="email" name="buyer_email" id="buyer_email" value="{{ old('buyer_email', $ticket->buyer_email) }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('buyer_email')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $ticket->quantity) }}" 
                                   min="1" max="10"
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('quantity')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Total: {{ $ticket->event ? 'RM ' . number_format($ticket->event->ticket_price * $ticket->quantity, 2) : 'N/A' }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                    required>
                                <option value="pending" {{ old('status', $ticket->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $ticket->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="canceled" {{ old('status', $ticket->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('tickets.show', $ticket) }}" 
                               class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                                Update Ticket
                            </button>
                        </div>
                    </form>

                    <!-- Delete Ticket Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-danger-600 mb-4">Danger Zone</h3>
                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this ticket? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-danger-600 hover:bg-danger-700 text-white font-bold py-2 px-4 rounded">
                                Delete Ticket
                            </button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection