<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StaffPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     if ($user->role_id === 1) {
    //         return true;
    //     }
    
    //     // Check if categories match or adminUser has assigned users of category
    //     // return $user->role->agency_id ;
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Staff $staff): bool
    {
        //return $user->role_id === 1;

        if ($user->role_id === 1) {
            return true;
        }
    
        // Check if categories match or adminUser has assigned users of category
        return $staff->category_id === $user->role->agency_id || $staff->category_id === 1;
    }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Staff $staff): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    public function delete(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    public function restore(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Staff $staff): bool
    {
        return $user->role_id === 1;
    }
}
