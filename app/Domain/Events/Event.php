<?php

namespace Pi\Domain\Events;
use Pi\Domain\Calendar\CalendarEntry;
use Pi\Domain\Traits\CalendarEvent;

/**
 * Pi\Domain\Events\Event
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property \Carbon\Carbon $start_datetime
 * @property boolean $all_day
 * @property \Carbon\Carbon $finish_datetime
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $string_start_datetime
 * @property-read mixed $string_finish_datetime
 * @property-read mixed $period_string
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereStartDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereAllDay($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereFinishDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Domain\Events\Event whereUpdatedAt($value)
 */
class Event extends \Eloquent implements CalendarEntry
{
    protected $dates = ['start_datetime', 'finish_datetime'];

    use CalendarEvent;

    protected function getCalendarIdPrefix()
    {
        return 'global';
    }
}