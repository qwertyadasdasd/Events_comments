<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_role',
        'requested_role',
        'reason',
        'status',
        'processed_by',
        'admin_comment',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public static function getAvailableRoles($currentRole)
    {
        $roles = [
            User::ROLE_GUEST => [User::ROLE_MEMBER, User::ROLE_AUTHOR],
            User::ROLE_MEMBER => [User::ROLE_AUTHOR, User::ROLE_EDITOR],
            User::ROLE_AUTHOR => [User::ROLE_EDITOR, User::ROLE_ADMIN],
            User::ROLE_EDITOR => [User::ROLE_ADMIN],
            User::ROLE_ADMIN => [],
        ];

        return $roles[$currentRole] ?? [];
    }
}
