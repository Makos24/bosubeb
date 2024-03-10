<?php

namespace App\Policies;

use App\Models\GradeBenefits;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GradeBenefitsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, GradeBenefits $gradeBenefits): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GradeBenefits $gradeBenefits): bool
    {
        //
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GradeBenefits $gradeBenefits): bool
    {
        //
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GradeBenefits $gradeBenefits): bool
    {
        //
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GradeBenefits $gradeBenefits): bool
    {
        //
        return $user->role_id === 1;
    }
}
