<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Admin') ?  true : false;
    }

    public function view(User $user)
    {
        return $this->viewAny($user);
    }

    public function create(User $user)
    {
        return $this->viewAny($user);
    }

    public function update(User $user)
    {
        return $this->viewAny($user);
    }

    public function delete(User $user) {
       return $this->viewAny($user);
    }
}
