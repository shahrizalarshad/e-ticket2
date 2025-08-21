<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        
        $event = Event::findOrFail($validated['event_id']);
        $user = Auth::user();
        
        // Check if event has already passed
        if ($event->hasPassed()) {
            return back()->withErrors([
                'event' => 'Cannot book tickets for events that have already occurred.'
            ])->withInput();
        }
        
        // Check VIP access restrictions
        if (!$event->canUserBook($user)) {
            return back()->withErrors([
                'event' => 'This event is currently in VIP access period. Only VIP customers can book tickets during the first 24 hours.'
            ])->withInput();
        }
        
        // Check if event has enough capacity
        $soldTickets = $event->tickets()->where('status', 'confirmed')->sum('quantity');
        
        if (($soldTickets + $validated['quantity']) > $event->capacity) {
            return back()->withErrors([
                'quantity' => 'Sorry, only ' . ($event->capacity - $soldTickets) . ' tickets are available for this event.'
            ])->withInput();
        }
        
        // Create the ticket
        $ticket = Ticket::create([
            'event_id' => $validated['event_id'],
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'quantity' => $validated['quantity'],
            'status' => 'confirmed',
            'user_id' => $user ? $user->id : null,
        ]);
        
        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket purchased successfully! Confirmation details have been sent to your email.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('event');
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $ticket->load('event');
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Cancel a ticket booking
     */
    public function cancel(Ticket $ticket)
    {
        // Check if user owns this ticket or is admin
        $user = Auth::user();
        if (!$user || ($ticket->user_id !== $user->id && !$user->isAdmin())) {
            abort(403, 'Unauthorized to cancel this ticket.');
        }

        // Check if event has already passed
        if ($ticket->event->hasPassed()) {
            return back()->withErrors([
                'ticket' => 'Cannot cancel tickets for events that have already occurred.'
            ]);
        }

        // Update ticket status to cancelled
        $ticket->update(['status' => 'cancelled']);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket cancelled successfully! Your refund will be processed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        // Only admins can permanently delete tickets
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to delete tickets.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}
