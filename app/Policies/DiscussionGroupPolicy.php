<?php

namespace Pi\Policies;
use Pi\Auth\User;

class DiscussionGroupPolicy
{
    public function before(User $user, $ability)
    {
        return $user->isModerator();
    }

}
