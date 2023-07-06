<?php

namespace App\Policies;

use App\Models\User;

class JobPolicy
{
    public function create(User $user) {
        
        if($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
}
