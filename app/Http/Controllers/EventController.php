<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('Event.index', compact('events'));  // ← изменено
    }

    public function create()
    {
        return view('Event.create');  // ← изменено
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:events,slug',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        Event::create($data);
        return redirect()->route('event.index');
    }

    public function edit(Event $event)
    {
        return view('Event.edit', compact('event'));  // ← изменено
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:events,slug,' . $event->id,
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        $event->update($data);
        return redirect()->route('event.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.index');
    }
}
