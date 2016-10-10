<?php

namespace Pi\Clients\Courses;

use Illuminate\Database\Eloquent\Collection;
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
class CourseUserPivot extends Pivot
{
    const CURRENT_ARTICLE = 'currentArticle';
    const CURRENT_POINTS = 'currentPoints';
    const PASSED_ARTICLES = 'passedArticles';

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

    public function getArticlesAttribute()
    {
        return new Collection(json_decode($this->read_articles));
    }

    public function setArticlesAttribute(Collection $value)
    {
        $this->read_articles = json_encode($value->toArray());
    }


}