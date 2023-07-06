<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{

    public function create(User $user)
    {
        return (
            $user->hasRole(['Admin', 'Writer', 'Ambassador']) ||
            $user->hasPermissionTo('create_course')) ? 
            true : false;
    }

    public function update(User $user, Course $course)
    {
        return (
            $user->hasRole(['Admin', 'Writer', 'Ambassador']) ||
            $user->hasPermissionTo('edit_course')) ||
            $course->author()->is($user) ? 
            true : false;
    }

    public function delete(User $user) {
        return $user->hasRole('Admin') ||
                $user->hasPermissionTo('delete_course') ? 
                true : false;
    }
}
