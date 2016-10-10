<?php

namespace Pi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class RoomAttributePolicy
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
}
