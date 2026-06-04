<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Services\RoleRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\RoleRequest;

class RoleRequestController extends Controller
{
    protected RoleRequestService $service;

    public function __construct(RoleRequestService $service)
    {
        $this->middleware('auth'); // Добавьте эту строку
        $this->service = $service;
    }

    public function create()
    {
        $user = Auth::user(); // Исправлено

        // Проверяем, есть ли активный запрос
        $hasPendingRequest = RoleRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        // Проверяем, существует ли метод getAvailableRoles
        if (method_exists(RoleRequest::class, 'getAvailableRoles')) {
            $availableRoles = RoleRequest::getAvailableRoles($user->role);
        } else {
            // Заглушка или логика по умолчанию
            $availableRoles = ['admin', 'moderator', 'editor'];
        }

        return view('role-requests.create', compact('availableRoles', 'hasPendingRequest', 'user'));
    }

    public function show() // Исправлено: show вместо Show
    {
        $user = Auth::user();
        $requests = RoleRequest::where('user_id', $user->id)->get();
        return view('role-requests.show', compact('user', 'requests'));
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

        // Проверяем существование метода
        if (method_exists(RoleRequest::class, 'getAvailableRoles')) {
            $availableRoles = RoleRequest::getAvailableRoles($user->role);
            $availableRoles = is_array($availableRoles) ? $availableRoles : $availableRoles->toArray();
        } else {
            $availableRoles = ['admin', 'moderator', 'editor'];
        }

        $request->validate([
            'requested_role' => [
                'required',
                Rule::in($availableRoles),
            ],
            'reason' => 'required|string|min:10|max:500',
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
