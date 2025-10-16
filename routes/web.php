<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Prepare a more versatile homepage with featured and latest events
    $featuredEvents = \App\Models\Event::query()
        ->whereNotNull('start_date')
        ->where('start_date', '>=', now())
        ->orderBy('start_date')
        ->take(3)
        ->get();

    $latestEvents = \App\Models\Event::query()
        ->latest()
        ->take(4)
        ->get();

    // Trending locations by event count
    $trendingLocations = \App\Models\Event::query()
        ->selectRaw('location, COUNT(*) as cnt')
        ->whereNotNull('location')
        ->groupBy('location')
        ->orderByDesc('cnt')
        ->limit(6)
        ->pluck('location');

    return view('welcome', compact('featuredEvents', 'latestEvents', 'trendingLocations'));
})->name('home');

// Public routes - anyone can view events
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Event management - requires authentication (must come before {event} routes)
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Public event show route (must come after specific routes)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Ticket purchasing - requires authentication
Route::middleware('auth')->group(function () {
    Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::patch('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
