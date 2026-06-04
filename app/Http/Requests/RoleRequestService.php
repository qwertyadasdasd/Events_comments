<?php

namespace App\Services;

use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleRequestService
{
    public function create(array $data, int $userId): RoleRequest
    {
        try {
            $roleRequest = RoleRequest::create(array_merge($data, [
                'user_id' => $userId,
                'status' => 'pending'
            ]));

            return $roleRequest;
        } catch (\Exception $e) {
            Log::error('Failed to create role request: ' . $e->getMessage());
            throw new \RuntimeException('Не удалось создать запрос на изменение роли');
        }
    }

    public function approveRequest(RoleRequest $roleRequest, ?int $processedBy = null): bool
    {
        if ($roleRequest->status !== 'pending') {
            throw new \InvalidArgumentException('Этот запрос уже обработан');
        }

        return DB::transaction(function () use ($roleRequest, $processedBy) {
            $roleRequest->update([
                'status' => 'approved',
                'processed_by' => $processedBy,
                'processed_at' => now()
            ]);

            $user = User::find($roleRequest->user_id);
            if ($user) {
                $user->update(['role' => $roleRequest->requested_role]);
            }

            return true;
        });
    }

    public function rejectRequest(RoleRequest $roleRequest, ?int $processedBy = null, ?string $comment = null): bool
    {
        if ($roleRequest->status !== 'pending') {
            throw new \InvalidArgumentException('Этот запрос уже обработан');
        }

        return $roleRequest->update([
            'status' => 'rejected',
            'processed_by' => $processedBy,
            'processed_at' => now(),
            'admin_comment' => $comment
        ]);
    }

    public function getPendingRequests(): \Illuminate\Database\Eloquent\Collection
    {
        return RoleRequest::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function hasPendingRequest(int $userId): bool
    {
        return RoleRequest::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }
}
