<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null; // Возвращаем null, чтобы продолжить проверку
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_MEMBER,
            User::ROLE_EDITOR,
            User::ROLE_AUTHOR,
        ]);
    }

    public function view(User $user, Event $event): bool
    {
        return in_array($user->role, [
            User::ROLE_MEMBER,
            User::ROLE_EDITOR,
            User::ROLE_AUTHOR,
        ]);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_EDITOR,
            User::ROLE_AUTHOR
        ]);
    }

    public function update(User $user, Event $event): bool
    {
        if ($user->hasRole('editor')) {
            return true;
        }
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('editor')) {
            return true;
        }

        if ($user->hasRole('author')) {
            return $user->id === $event->user_id;
        }

        return false;
    }

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
