<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoleRequestController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $availableRoles = RoleRequest::getAvailableRoles($user->role);
        $hasPendingRequest = RoleRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        return view('role-requests.create', compact('availableRoles', 'hasPendingRequest'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $hasPendingRequest = RoleRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return back()->with('error', 'У вас уже есть активный запрос на повышение роли.');
        }

        $availableRoles = RoleRequest::getAvailableRoles($user->role);

        $request->validate([
            'requested_role' => [
                'required',
                Rule::in($availableRoles),
            ],
            'reason' => 'required|min:10|max:500',
        ], [
            'requested_role.required' => 'Выберите желаемую роль.',
            'requested_role.in' => 'Выбранная роль недоступна.',
            'reason.required' => 'Укажите причину повышения роли.',
            'reason.min' => 'Причина должна содержать минимум 10 символов.',
            'reason.max' => 'Причина не должна превышать 500 символов.',
        ]);

        RoleRequest::create([
            'user_id' => $user->id,
            'current_role' => $user->role,
            'requested_role' => $request->requested_role,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return redirect()->route('role-request.my-requests')
            ->with('success', 'Запрос на повышение роли успешно отправлен.');
    }

    public function myRequests()
    {
        $user = Auth::user();
        $requests = RoleRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('role-requests.my-requests', compact('requests'));
    }
}
