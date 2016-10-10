<?php

namespace Pi\Policies;

use Pi\Auth\User;

class BannerPolicy
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

    public function manage(User $user, $banner, $client)
    {
        if ( $user->id === $banner->created_by ) return true;
        if ( $banner->id && $banner->client_id != $client->id ) return false;

        return $user->isModerator($client);
    }
}
