<?php

namespace Pi\Clients\Milestones;
use Pi\Auth\User;
use Pi\Constants;
use Pi\Domain\Calendar\CalendarEntry;
use Pi\Clients\Client;
use Pi\Clients\Courses\Course;

/**
 * Pi\Clients\Milestones\Milestone
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $assignable_id
 * @property string $assignable_type
 * @property string $title
 * @property \Carbon\Carbon $finish_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read Client $client
 * @property-read mixed $string_finish_datetime
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereAssignableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereAssignableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereFinishAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Milestones\Milestone whereUpdatedAt($value)
 */
class Milestone extends \Eloquent implements CalendarEntry
{
    const ASSIGNABLE_TYPE_CLIENT = 'client';
    const ASSIGNABLE_TYPE_USERGROUP = 'usergroup';

    protected $dates = ['finish_at'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->belongsToMany(User::class, 'milestone_user')->withTimestamps();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return string
     */
    public function getStringFinishDatetimeAttribute()
    {
        return $this->finish_at->format(Constants::getDateFormat());
    }

    /**
     * @return string
     */
    function getCalendarId()
    {
        return 'milestone_' . $this->id;
    }

    /**
     * @return string
     */
    function getCalendarTitle()
    {
        return $this->title;
    }

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarStart()
    {
        return $this->finish_at;
    }

    /**
     * @return \Carbon\Carbon
     */
    function getCalendarEnd()
    {
        return $this->finish_at;
    }

    /**
     * @return bool
     */
    function getCalendarAllDay()
    {
        return true;
    }
}