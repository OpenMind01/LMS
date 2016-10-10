<?php

namespace Pi\Policies;

class UserPolicy
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

    public function impersonate($user)
    {
        return (\Auth::user()->isSuperAdmin());
    }
}
