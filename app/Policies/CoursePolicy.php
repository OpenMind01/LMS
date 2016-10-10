<?php

namespace Pi\Policies;

use Pi\Auth\Permission;
use Pi\Auth\User;
use Pi\Clients\Courses\Course;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Course $course)
    {
        return true;
    }

    public function manage(User $user, Course $course)
    {

        return $user->isAdmin();
        // return true;
    }
}