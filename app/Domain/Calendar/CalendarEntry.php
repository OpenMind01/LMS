<?php

namespace Pi\Domain\Calendar;

interface CalendarEntry
{
    /**
     * @return string
     */
    function getCalendarId();

    /**
     * @return string
     */
    function getCalendarTitle();

    /**
     * @return bool
     */
    function getCalendarAllDay();

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarStart();

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarEnd();
}