<?php

namespace Pi\Clients\Usergroups;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Courses\Course;
use Pi\Usergroups\Usergroup;

/**
 * Pi\Clients\Usergroups\ClientUsergroup
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $usergroup_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $course_id
 * @property-read Client $client
 * @property-read Course $course
 * @property-read Usergroup $usergroup
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereUsergroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Usergroups\ClientUsergroup whereCourseId($value)
 */
class ClientUsergroup extends \Eloquent
{
    protected $table = 'client_usergroups';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function usergroup()
    {
        return $this->belongsTo(Usergroup::class, 'usergroup_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'client_usergroup_id');
    }
}