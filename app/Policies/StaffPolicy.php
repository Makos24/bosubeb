<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;

class StaffPolicy
{
    public function view(User $user, Staff $staff): bool
    {
        if ($user->role_id === 1) {
            return true;
        }

        return $staff->category_id === $user->role->agency_id || $staff->category_id === 1;
    }

    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    public function delete(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }

    public function restore(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }

    public function forceDelete(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }
}
