<?php

namespace App\Services;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;

class EventService
{
    public function getEvents()
    {
        return Event::paginate(10);
    }

    public function getAllEvents()
    {
        return Event::all();
    }

    public function getEventById($id)
    {
        return Event::findOrFail($id);
    }

    public function createEvent(array $data)
    {
        try {
            $event = Event::create($data);
            return $event;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function updateEvent(Event $event, array $data)
    {
        $event->update($data);
        return $event;
    }

    public function destroyEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return true;
    }

    public function getEventsByDate($date)
    {
        return Event::whereDate('event_date', $date)->paginate(10);
    }

    public function getUpcomingEvents()
    {
        return Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(10);
    }
}
