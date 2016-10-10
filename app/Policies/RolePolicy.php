<?php

namespace Pi\Policies;

use Pi\Auth\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function assign(User $user)
    {
        return ($user->isSuperAdmin());
    }
}
