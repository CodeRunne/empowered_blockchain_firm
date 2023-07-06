<?php

namespace App\Policies;

use App\Models\User;

class SubscribePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Admin') ? true : false;
        
    }
}
