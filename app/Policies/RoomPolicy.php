<?php

namespace Pi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Pi\Auth\User;
use Pi\Clients\Locations\Rooms\Room;

class RoomPolicy
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

    public function manage(User $user, Room $room)
    {
        return true;
    }
}
