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

        // Подсчеты
        $commentsCount = Comment::count();
        $eventsCount = Event::count();

        if ($user->created_at) {
            $daysRegistered = $user->created_at->diffInDays(now()) + 1;
        } else {
            $daysRegistered = 1;
        }

        $myRoleRequests = RoleRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('commentsCount', 'eventsCount', 'daysRegistered', 'myRoleRequests'));
    }
}
