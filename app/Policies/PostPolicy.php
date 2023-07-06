<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{

    public function create(User $user)
    {
        return (
            $user->hasRole(['Admin', 'Writer', 'Ambassador']) ||
            $user->hasPermissionTo('create_post')) ? 
            true : false;
    }

    public function update(User $user, Post $post)
    {
        return (
            ($user->hasRole(['Admin', 'Writer', 'Ambassador']) && $user->hasPermissionTo('edit_post')) ||
            $user->hasPermissionTo('edit_post')) ||
            $post->author()->is($user) ? 
            true : false;
    }

    public function delete(User $user) {
        return ($user->hasRole('Admin') &&      $user->hasPermissionTo('delete_post')) ||
            $user->hasPermissionTo('delete_post') ? 
            true : false;
    }
}
