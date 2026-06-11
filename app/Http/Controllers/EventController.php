<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('Event.index', compact('events'));
    }

    public function create()
    {
        return view('Event.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
            'start_date' => 'nullable|date',
            'guests' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Событие успешно создано!');
    }

    public function edit(Event $event)
    {
        return view('Event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
            'start_date' => 'nullable|date',
            'guests' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Событие обновлено!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Событие удалено!');
    }
}
