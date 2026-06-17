<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use App\Models\RoleRequest;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Проверяем, админ ли пользователь
        $isAdmin = $user->role === 'admin';

        // Личные события и комментарии
        $myCommentsCount = Comment::where('user_id', $user->id)->count();
        $myEventsCount = Event::where('user_id', $user->id)->count();

        if ($isAdmin) {
            $totalCommentsCount = Comment::count();
            $totalEventsCount = Event::count();
            $totalUsers = \App\Models\User::count();
            $pendingRequests = RoleRequest::where('status', 'pending')->count();
        } else {
            $totalCommentsCount = 0;
            $totalEventsCount = 0;
            $totalUsers = 0;
            $pendingRequests = 0;
        }

        // Дней с регистрации
        if ($user->created_at) {
            $daysRegistered = $user->created_at->diffInDays(now()) + 1;
        } else {
            $daysRegistered = 1;
        }

        // Запросы на роль
        $myRoleRequests = RoleRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact(
            'myCommentsCount',
            'myEventsCount',
            'totalCommentsCount',
            'totalEventsCount',
            'totalUsers',
            'pendingRequests',
            'daysRegistered',
            'myRoleRequests',
            'isAdmin'
        ));
    }
}
