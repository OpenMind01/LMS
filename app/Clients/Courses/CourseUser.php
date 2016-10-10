<?php

namespace Pi\Clients\Courses;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Pi\Auth\User;
use Pi\Domain\Model;

/**
 * Pi\Clients\Courses\CourseUser
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $user_id
 * @property boolean $passed
 * @property integer $progress_percent
 * @property string $progress
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Course $course
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser wherePassed($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereProgressPercent($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereProgress($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\CourseUser whereUpdatedAt($value)
 */
class CourseUser extends Model
{
    const CURRENT_ARTICLE = 'currentArticle';
    const CURRENT_POINTS = 'currentPoints';
    const PASSED_ARTICLES = 'passedArticles';


    public static $completion_icon = [
        1 => 'fa-check',
        0 => 'fa-exclamation',
    ];

    protected $casts = [
        'progress' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Getters */

    public function getCurrentArticleId()
    {
        return array_get($this->progress, self::CURRENT_ARTICLE, null);
    }

    public function getPassedArticles()
    {
        return array_get($this->progress, self::PASSED_ARTICLES, []);
    }

    public function getReadArticlesAttribute($value)
    {
        return json_decode($value);
    }

    public function setReadArticlesAttribute($value)
    {
        $this->attributes['read_articles'] = json_encode($value);
    }

    public function getCompletionIconAttribute()
    {
        $icon_key = $this->isComplete() == true ? 1 : 0;
        if (array_key_exists($icon_key, self::$completion_icon)) return self::$completion_icon[$icon_key];
    }

    public function isComplete()
    {
        return $this->progress_percent == 100;
    }

    public function getCompletionStatusAttribute()
    {
        return $this->isComplete() ? 'Complete' : 'Incomplete';
    }


    public function getCompletionDateAttribute()
    {
        if ($this->isComplete()) {
            return $this->updated_at;
        }
        return null;
    }



}