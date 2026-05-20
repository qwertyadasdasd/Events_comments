<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Пример для канала событий
Broadcast::channel('events.{eventId}', function ($user, $eventId) {
    return $user->can('view', Event::find($eventId));
});
