<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    // Список всех запросов
    public function index()
    {
        $requests = RoleRequest::with(['user', 'processedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.role-requests.index', compact('requests'));
    }

    // Просмотр деталей запроса
    public function show(RoleRequest $roleRequest)
    {
        $roleRequest->load(['user', 'processedBy']);
        return view('admin.role-requests.show', compact('roleRequest'));
    }

    // Обработка запроса (одобрение/отклонение)
    public function process(Request $request, RoleRequest $roleRequest)
    {
        $validated = $request->validate([
            'action' => 'required|in:approved,rejected',
            'admin_comment' => 'nullable|string|max:500',
        ]);

        if ($roleRequest->status !== 'pending') {
            return back()->with('error', 'Этот запрос уже обработан.');
        }

        $roleRequest->status = $validated['action'];
        $roleRequest->processed_by = Auth::id();
        $roleRequest->admin_comment = $validated['admin_comment'] ?? null;
        $roleRequest->processed_at = now();

        // Если запрос одобрен, повышаем роль пользователя
        if ($validated['action'] === 'approved') {
            $user = User::find($roleRequest->user_id);
            $user->role = $roleRequest->requested_role;
            $user->save();
        }

        $roleRequest->save();

        // Здесь можно отправить уведомление пользователю

        $message = $validated['action'] === 'approved'
            ? 'Запрос одобрен. Роль пользователя повышена.'
            : 'Запрос отклонен.';

        return redirect()->route('admin.role-requests.index')
            ->with('success', $message);
    }
}
