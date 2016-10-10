<?php
/**
 * Created by Justin McCombs.
 * Date: 11/9/15
 * Time: 11:53 AM
 */

namespace Pi\Clients\Courses\Quizzes;


use Illuminate\Database\Eloquent\SoftDeletes;
use Pi\Auth\User;
use Pi\Clients\Client;

/**
 * Pi\Clients\Courses\Quizzes\QuizAttempt
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $quiz_id
 * @property integer $user_id
 * @property integer $score
 * @property boolean $passed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Client $client
 * @property-read User $user
 * @property-read Quiz $quiz
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereQuizId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt wherePassed($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizAttempt whereUpdatedAt($value)
 */
class QuizAttempt extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [

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
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
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