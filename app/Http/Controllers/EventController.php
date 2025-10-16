<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Add simple search and filtering to support a versatile homepage search
        $search = request()->string('q');
        $upcoming = request()->boolean('upcoming');
        $free = request()->boolean('free');
        $location = request()->string('location');

        $eventsQuery = Event::query();

        if ($search->isNotEmpty()) {
            $term = '%' . $search . '%';
            $eventsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('description', 'like', $term)
                  ->orWhere('location', 'like', $term);
            });
        }

        if ($upcoming) {
            $eventsQuery->whereNotNull('start_date')
                        ->where('start_date', '>=', now());
        }

        if ($free) {
            $eventsQuery->where(function ($q) {
                $q->whereNull('ticket_price')
                  ->orWhere('ticket_price', '=', 0);
            });
        }

        if ($location->isNotEmpty()) {
            $eventsQuery->where('location', 'like', '%' . $location . '%');
        }

        $events = $eventsQuery->paginate(12)->withQueryString();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = 1; // For now, using a default user ID

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Check if there are any tickets for this event
        if ($event->tickets()->count() > 0) {
            return redirect()->route('events.index')
                ->with('error', 'Cannot delete event with existing tickets.');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
