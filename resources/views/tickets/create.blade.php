@extends('layouts.main')

@section('title', 'Buy Tickets - ' . $event->name)

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('events.show', $event) }}"
               class="inline-flex items-center text-sm font-medium text-neutral-500 hover:text-neutral-700 transition-colors duration-200">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Event
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Event Summary Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden sticky top-6">
                        <!-- Event Header -->
                        <div class="bg-gradient-to-r from-primary-600 to-accent-600 px-6 py-8 text-white">
                            <h2 class="text-xl font-bold mb-2">{{ $event->name }}</h2>
                            <div class="space-y-2 text-sm opacity-90">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y g:i A') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Info -->
                        <div class="p-6">
                            <div class="text-center mb-4">
                                <div class="text-2xl font-bold text-neutral-900 mb-1">
                                    RM {{ number_format($event->ticket_price, 2) }}
                                </div>
                                <div class="text-sm text-neutral-500">per ticket</div>
                            </div>

                            <!-- Order Summary -->
                            <div id="order-summary" class="border-t pt-4 hidden">
                                <h3 class="font-medium text-neutral-900 mb-3">Order Summary</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-neutral-600">Tickets (<span id="summary-quantity">0</span>)</span>
                                        <span class="font-medium" id="summary-subtotal">RM 0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-neutral-600">Service Fee</span>
                                        <span class="font-medium" id="summary-fee">RM 0.00</span>
                                    </div>
                                    <div class="border-t pt-2 flex justify-between font-semibold">
                                        <span>Total</span>
                                        <span id="summary-total">RM 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-8">
                        <div class="mb-8">
                            <h1 class="text-2xl font-bold text-neutral-900 mb-2">Purchase Tickets</h1>
                            <p class="text-neutral-600">Fill in your details to complete your ticket purchase</p>

                            @if($event->isVipAccessPeriod() && (!auth()->user() || !auth()->user()->isVip()))
                                <div class="mt-4 bg-accent-50 border border-accent-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-accent-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-accent-800 mb-1">VIP Access Period</h3>
                                            <p class="text-sm text-accent-700">This event is currently in VIP access period. Only VIP customers can purchase tickets during the first 24 hours after event creation.</p>
                                            <p class="text-sm text-accent-600 mt-1">Regular booking will be available after {{ $event->created_at->addHours(24)->format('M d, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($event->available_tickets <= 0)
                                <div class="mt-4 bg-danger-50 border border-danger-200 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-danger-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-danger-800 mb-1">Event Sold Out</h3>
                                            <p class="text-sm text-danger-700">Sorry, this event is currently sold out. No tickets are available for purchase.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($errors->any())
                            <div class="mb-6 bg-danger-50 border border-danger-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-danger-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-danger-800 mb-2">Please correct the following errors:</h3>
                                        <ul class="text-sm text-danger-700 list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('tickets.store') }}" method="POST" id="ticket-form" class="space-y-6">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <!-- Personal Information -->
                            <div>
                                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Personal Information</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-6">
                                        <label for="buyer_name" class="block text-sm font-medium text-neutral-700 mb-2">
                                            Full Name *
                                        </label>
                                        <input type="text"
                                               name="buyer_name"
                                               id="buyer_name"
                                               value="{{ old('buyer_name') }}"
                                               class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('buyer_name') border-danger-300 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                               placeholder="Enter your full name"
                                               required>
                                        @error('buyer_name')
                                            <div class="mt-2 flex items-center text-sm text-danger-600">
                                                <svg class="h-4 w-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="buyer_email" class="block text-sm font-medium text-neutral-700 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email"
                                               name="buyer_email"
                                               id="buyer_email"
                                               value="{{ old('buyer_email') }}"
                                               class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('buyer_email') border-danger-300 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                               placeholder="Enter your email address"
                                               required>
                                        @error('buyer_email')
                                            <div class="mt-2 flex items-center text-sm text-danger-600">
                                                <svg class="h-4 w-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <p class="mt-1 text-xs text-neutral-500">Your tickets will be sent to this email</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Ticket Quantity -->
                            <div>
                                <h2 class="text-lg font-semibold text-neutral-900 mb-4">Ticket Selection</h2>
                                <div class="bg-neutral-50 rounded-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="font-medium text-neutral-900">General Admission</h3>
                                            <p class="text-sm text-neutral-600">RM {{ number_format($event->ticket_price, 2) }} per ticket</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button"
                                                    id="decrease-qty"
                                                    class="w-10 h-10 rounded-full border border-neutral-300 flex items-center justify-center hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <input type="number"
                                                   name="quantity"
                                                   id="quantity"
                                                   min="1"
                                                   max="10"
                                                   value="{{ old('quantity', 1) }}"
                                                   class="w-16 text-center border border-neutral-300 rounded-lg py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('quantity') border-danger-300 focus:ring-danger-500 focus:border-danger-500 @enderror"
                                                   required>
                                            <button type="button"
                                                    id="increase-qty"
                                                    class="w-10 h-10 rounded-full border border-neutral-300 flex items-center justify-center hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @error('quantity')
                                        <p class="text-sm text-danger-600">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-neutral-500">Maximum 10 tickets per purchase</p>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="border-t pt-6">
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox"
                                           id="terms"
                                           name="terms"
                                           class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded"
                                           required>
                                    <label for="terms" class="text-sm text-neutral-600">
                                        I agree to the <a href="#" class="text-primary-600 hover:text-primary-500">Terms and Conditions</a>
                                        and <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a>.
                                        I understand that tickets are non-refundable.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="border-t pt-6">
                                <button type="submit"
                                     class="w-full bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 flex items-center justify-center"
                                     x-data="{ loading: false }"
                                     @click="loading = true"
                                     :disabled="loading">
                                 <svg x-show="!loading" class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                 </svg>
                                 <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                     <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                     <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                 </svg>
                                 <span x-text="loading ? 'Processing...' : 'Complete Purchase'"></span>
                             </button>
                                <p class="mt-3 text-xs text-neutral-500 text-center">
                                    🔒 Your payment information is secure and encrypted
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decrease-qty');
            const increaseBtn = document.getElementById('increase-qty');
            const orderSummary = document.getElementById('order-summary');
            const ticketPrice = {{ $event->ticket_price }};
            const serviceFeeRate = 0.05; // 5% service fee

            function updateOrderSummary() {
                const quantity = parseInt(quantityInput.value) || 0;
                const subtotal = quantity * ticketPrice;
                const serviceFee = subtotal * serviceFeeRate;
                const total = subtotal + serviceFee;

                document.getElementById('summary-quantity').textContent = quantity;
                document.getElementById('summary-subtotal').textContent = 'RM ' + subtotal.toFixed(2);
                document.getElementById('summary-fee').textContent = 'RM ' + serviceFee.toFixed(2);
                document.getElementById('summary-total').textContent = 'RM ' + total.toFixed(2);

                if (quantity > 0) {
                    orderSummary.classList.remove('hidden');
                } else {
                    orderSummary.classList.add('hidden');
                }
            }

            function updateQuantity(change) {
                const currentValue = parseInt(quantityInput.value) || 1;
                const newValue = Math.max(1, Math.min(10, currentValue + change));
                quantityInput.value = newValue;
                updateOrderSummary();
            }

            decreaseBtn.addEventListener('click', () => updateQuantity(-1));
            increaseBtn.addEventListener('click', () => updateQuantity(1));
            quantityInput.addEventListener('input', updateOrderSummary);

            // Initialize order summary
            updateOrderSummary();
        });
    </script>
@endsection
