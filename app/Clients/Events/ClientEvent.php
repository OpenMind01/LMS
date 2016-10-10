<?php

namespace Pi\Clients\Events;

use Pi\Domain\Calendar\CalendarEntry;
use Pi\Domain\Traits\CalendarEvent;

/**
 * Pi\Clients\Events\ClientEvent
 *
 * @property integer $id
 * @property integer $client_id
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
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereStartDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereAllDay($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereFinishDatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Events\ClientEvent whereUpdatedAt($value)
 */
class ClientEvent extends \Eloquent implements CalendarEntry
{
    protected $dates = ['start_datetime', 'finish_datetime'];

    use CalendarEvent;

    protected function getCalendarIdPrefix()
    {
        return 'client';
    }
}