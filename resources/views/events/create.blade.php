@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-neutral-800 leading-tight">
        {{ __('Create Event') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-neutral-900">
                    <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
                        @csrf

                        <!-- Event Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700">Event Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-neutral-700">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-neutral-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-neutral-700">Start Date</label>
                            <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('start_date')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-neutral-700">End Date</label>
                            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('end_date')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-neutral-700">Capacity</label>
                            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" 
                                   min="1" max="10000"
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('capacity')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ticket Price -->
                        <div>
                            <label for="ticket_price" class="block text-sm font-medium text-neutral-700">Ticket Price ($)</label>
                            <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price') }}" 
                                   min="0" step="0.01" max="9999.99"
                                   class="mt-1 block w-full rounded-md border-neutral-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                   required>
                            @error('ticket_price')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('events.index') }}" 
                               class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                                Create Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
@endsection