<?php

namespace Pi\Clients\Schedule;

use Pi\Domain\Model;

/**
 * Pi\Clients\Schedule\Meeting
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $user_id
 * @property integer $administrator_id
 * @property \Carbon\Carbon $start_at
 * @property string $reason
 * @property string $google_event_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereAdministratorId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereGoogleEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Schedule\Meeting whereUpdatedAt($value)
 */
class Meeting extends Model
{
    protected $dates = ['start_at'];
}