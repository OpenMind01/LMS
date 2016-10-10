<?php
/**
 * Created by Justin McCombs.
 * Date: 10/27/15
 * Time: 4:32 PM
 */

namespace Pi\Clients\Courses\Quizzes;
use Pi\Clients\Courses\Article;

/**
 * Pi\Clients\Courses\Quizzes\Quiz
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $created_by
 * @property integer $article_id
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property integer $max_attempts
 * @property integer $pass_percentage
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizElement[] $elements
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizAttempt[] $attempts
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereMaxAttempts($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz wherePassPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\Quiz whereUpdatedAt($value)
 */
class Quiz extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required|integer',
        'created_by' => 'required|integer',
        'article_id' => 'required|integer',
        'name' => 'required',
    ];

    const TYPE_ANSWER = 1;
    const TYPE_DO = 2;
    public static $types = [
        self::TYPE_ANSWER => 'Answer',
        self::TYPE_DO => 'Do',
    ];
    
    /*
	|--------------------------------------------------------------------------
	| Rules
	|--------------------------------------------------------------------------
	*/
	public static function rules($id = null, $merge=[])
	{
		return array_merge(self::$rules, $merge);
	}
    

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
    public function elements()
    {
        return $this->hasMany(QuizElement::class)->orderBy('number', 'asc');
    }

    public function responses()
    {
        return $this->hasManyThrough(QuizElementResponse::class, QuizElement::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/


    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/

}

Quiz::deleting(function(Quiz $quiz) {
    // Delete Attempts, answers
    $quiz->attempts()->delete();
    $quiz->elements()->delete();
});