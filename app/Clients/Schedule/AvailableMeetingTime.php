<?php

namespace Pi\Clients\Schedule;

use Carbon\Carbon;

class AvailableMeetingTime
{
    /**
     * @var Carbon
     */
    private $startDateTime;

    /**
     * @var Carbon
     */
    private $endDateTime;

    public function __construct(Carbon $startDateTime, Carbon $endDateTime)
    {
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
    }

    /**
     * @return Carbon
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @return Carbon
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }
}