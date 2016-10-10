<?php

namespace Pi\Listeners\Milestones;

use Pi\Clients\Milestones\Milestone;
use Pi\Clients\Milestones\MilestonesService;
use Pi\Events\Clients\ClientUsersChanged;

class UpdateUserMilestones
{
    /**
     * @var MilestonesService
     */
    private $service;

    public function __construct(MilestonesService $service)
    {
        $this->service = $service;
    }

    public function onClientUsersChanged(ClientUsersChanged $event)
    {
        $milestones = $this->service->getClientMilestones($event->getClient());

        foreach($milestones as $milestone)
        {
            $this->service->syncMilestoneUsers($milestone);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            ClientUsersChanged::class,
            self::class . '@onClientUsersChanged'
        );
    }
}