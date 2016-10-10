<?php

namespace Pi\Usergroups;

use Pi\Clients\Courses\Course;
use Pi\Domain\Industries\Industry;

/**
 * Pi\Usergroups\Usergroup
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $title
 * @property boolean $ready
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Industry[] $industries
 * @property-read Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|UsergroupModule[] $modules
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereReady($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Usergroups\Usergroup whereUpdatedAt($value)
 */
class Usergroup extends \Eloquent
{
    protected $table = 'usergroups';

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'usergroup_industry', 'usergroup_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modules()
    {
        return $this->hasMany(UsergroupModule::class, 'usergroup_id');
    }
}