<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Публичные события + свои события
        $events = Event::where(function($query) {
            $query->where('is_public', true)
                ->orWhere('user_id', auth()->id());
        })
            ->orderBy('created_at', 'desc')
            ->get();

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
            'is_public' => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id();
        $data['is_public'] = $request->has('is_public');

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Событие успешно создано!');
    }

    public function edit(Event $event)
    {
        // Проверяем, что событие принадлежит текущему пользователю
        if ($event->user_id !== auth()->id()) {
            abort(403, 'Вы не можете редактировать это событие.');
        }
        return view('Event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Проверяем, что событие принадлежит текущему пользователю
        if ($event->user_id !== auth()->id()) {
            abort(403, 'Вы не можете редактировать это событие.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
            'start_date' => 'nullable|date',
            'guests' => 'nullable|string',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_public' => 'nullable|boolean',
        ]);

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Событие обновлено!');
    }

    public function destroy(Event $event)
    {
        // Проверяем, что событие принадлежит текущему пользователю
        if ($event->user_id !== auth()->id()) {
            abort(403, 'Вы не можете удалить это событие.');
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Событие удалено!');
    }

    public function myEvents()
    {
        $events = Event::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Event.my-events', compact('events'));
    }
}
