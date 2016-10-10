<?php

namespace Pi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Pi\Auth\User;
use Pi\Clients\Locations\Buildings\Building;

class BuildingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Building $building)
    {
        return true;
    }
}
