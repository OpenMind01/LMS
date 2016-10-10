<?php

namespace Pi\Domain\Traits;

use Pi\Constants;

/**
 * Trait CalendarEvent
 *
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $start_datetime
 * @property boolean $all_day
 * @property \Carbon\Carbon $finish_datetime
 *
 * @package Pi\Domain\Traits
 */
trait CalendarEvent
{
    protected abstract function getCalendarIdPrefix();

    public function getStringStartDatetimeAttribute()
    {
        return $this->start_datetime->format($this->all_day ? Constants::getDateFormat() : Constants::getDateTimeFormat());
    }

    public function getStringFinishDatetimeAttribute()
    {
        return $this->finish_datetime != null ? $this->finish_datetime->format(Constants::getDateTimeFormat()) : '';
    }

    public function getPeriodStringAttribute()
    {
        $format = $this->all_day ? Constants::getDateFormat() : Constants::getDateTimeFormat();

        if($this->finish_datetime != null)
        {
            return $this->start_datetime->format($format) . ' - ' . $this->finish_datetime->format($format);
        }
        else
        {
            return $this->start_datetime->format($format);
        }
    }

    /**
     * @return string
     */
    function getCalendarId()
    {
        return $this->getCalendarIdPrefix() . '_' . $this->id;
    }

    /**
     * @return string
     */
    function getCalendarTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    function getCalendarAllDay()
    {
        return $this->all_day;
    }

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarStart()
    {
        return $this->start_datetime;
    }

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarEnd()
    {
        return $this->finish_datetime;
    }
}