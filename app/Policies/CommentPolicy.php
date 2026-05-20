<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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

    public function create(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_EDITOR,
            User::ROLE_AUTHOR,
            User::ROLE_MEMBER  // Обычные пользователи тоже могут комментировать
        ]);
    }

    public function update(User $user, Comment $comment): bool
    {
        // Редактор может редактировать любой комментарий
        if ($user->hasRole('editor')) {
            return true;
        }

        // Автор может редактировать только свои комментарии
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        // Админ может удалять любые комментарии
        if ($user->hasRole('admin')) {
            return true;
        }

        // Редактор может удалять любые комментарии
        if ($user->hasRole('editor')) {
            return true;
        }

        // Автор может удалять только свои комментарии
        if ($user->hasRole('author')) {
            return $user->id === $comment->user_id;
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
