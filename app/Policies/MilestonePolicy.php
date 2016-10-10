<?php

namespace Pi\Policies;

use Pi\Auth\Permission;
use Pi\Auth\User;
use Pi\Clients\Milestones\Milestone;

class MilestonePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Milestone $milestone)
    {
        return $user->isModerator($milestone->client);
    }
}
