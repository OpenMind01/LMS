<?php
/**
 * Created by Justin McCombs.
 * Date: 10/6/15
 * Time: 9:18 AM
 */

namespace Pi\Clients\Membership;


use Pi\Auth\User;
use Pi\Clients\Client;

class ClientMembershipRepository
{

    public function addUserToClient(User $user, Client $client)
    {
        if ( $client->users()->whereUserId($user->id)->count() === 0 )
            $client->users()->attach($user->id);
        return $this;
    }

    public function removeUserFromClient(User $user, Client $client)
    {
        $client->users()->detach($user->id);
        return $this;
    }

}