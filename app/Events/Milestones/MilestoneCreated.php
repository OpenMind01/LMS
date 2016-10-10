<?php

namespace Pi\Events\Milestones;

use Pi\Clients\Milestones\Milestone;
use Pi\Events\Event;
use Illuminate\Queue\SerializesModels;

class MilestoneCreated extends Event
{
    use SerializesModels;

    /**
     * @var Milestone
     */
    private $milestone;

    /**
     * Create a new event instance.
     * @param Milestone $milestone
     */
    public function __construct(Milestone $milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * @return Milestone
     */
    public function getMilestone()
    {
        return $this->milestone;
    }
}
