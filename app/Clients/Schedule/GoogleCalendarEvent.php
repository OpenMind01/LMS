<?php

namespace Pi\Clients\Schedule;

use Carbon\Carbon;

class GoogleCalendarEvent
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var Carbon
     */
    private $startDateTime;

    /**
     * @var Carbon
     */
    private $endDateTime;

    public function __construct($title, Carbon $startDateTime, Carbon $endDateTime)
    {
        $this->title = $title;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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