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
        $events = Event::paginate(12);
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
