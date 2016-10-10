<?php

namespace Pi\Policies;

use Pi\Auth\User;
use Pi\Clients\Courses\Module;

class ModulePolicy
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

    public function show(User $user, Module $module)
    {
        if ( ! $module ) return false;



        return true;
    }

    public function manage(User $user, Module $module)
    {

        return true;

    }
}
