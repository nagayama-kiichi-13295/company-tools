<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    /**
     * 作成できるのは管理者だけ
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * 編集・削除できるのは管理者だけ
     */
    public function update(User $user, Announcement $announcement): bool
    {
        return $user->is_admin;
    }
    
    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->is_admin;
    }
}
