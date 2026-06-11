<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = RoleRequest::where('status', 'pending')->count();
        $totalRequests = RoleRequest::count();

        return view('admin.dashboard', compact('pendingRequests', 'totalRequests'));
    }

    public function roleRequests()
    {
        $requests = RoleRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.role-requests', compact('requests'));
    }

    public function approveRequest($id)
    {
        $request = RoleRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        // Обновляем роль пользователя
        $user = $request->user;
        $user->role = $request->requested_role;
        $user->save();

        return back()->with('success', 'Запрос одобрен. Роль пользователя обновлена.');
    }

    public function rejectRequest($id)
    {
        $request = RoleRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return back()->with('success', 'Запрос отклонен.');
    }
}
