<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Admin') && 
        $user->hasPermissionTo('view_all_users') ? 
        true : false;
    }

    public function view(User $user)
    {
        return $this->viewAny($user);
    }

    public function create(User $user)
    {
        return $user->hasRole('Admin') && 
        $user->hasPermissionTo('create_user') ? 
        true : false;
    }

    public function update(User $user)
    {
        return $user->hasRole('Admin') && 
        $user->hasPermissionTo('edit_user') ? 
        true : false;
    }

    public function delete(User $user)
    {
        return $user->hasRole('Admin') && 
        $user->hasPermissionTo('delete_user') ? 
        true : false;
    }
}
