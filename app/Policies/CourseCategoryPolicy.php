<?php

namespace App\Policies;

use App\Models\User;

class CourseCategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    
    public function view(User $user)
    {
        return $user
            ->hasRole(['Admin', 'Moderator', 'Writer', 'Ambassador']) ? 
                true : false;
    }

    public function create(User $user)
    {
        return $user
            ->hasRole(['Admin', 'Moderator', 'Writer', 'Ambassador']) ? 
                true : false;
    }

    public function update(User $user)
    {
        return $user
            ->hasRole(['Admin', 'Moderator', 'Writer', 'Ambassador']) ? 
                true : false;
    }

    public function delete(User $user)
    {
        return $user->hasRole('Admin') ? true : false;
    }
}
