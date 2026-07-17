<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * 管理者だけ作成・編集・削除
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->is_admin;
    }
}
