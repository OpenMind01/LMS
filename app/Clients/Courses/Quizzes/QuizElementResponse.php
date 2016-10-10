<?php
/**
 * Created by Justin McCombs.
 * Date: 10/27/15
 * Time: 4:32 PM
 */

namespace Pi\Clients\Courses\Quizzes;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pi\Clients\Courses\Quizzes\QuizElementResponse
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $quiz_element_id
 * @property integer $user_id
 * @property string $value
 * @property boolean $is_array
 * @property boolean $is_correct
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereQuizElementId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereIsArray($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereIsCorrect($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementResponse whereUpdatedAt($value)
 */
class QuizElementResponse extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required|integer',
        'user_id' => 'required|integer',
        'quiz_element_id' => 'required|integer',
        'value' => 'required',
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
	public function quizElement()
	{
		return $this->belongsTo(QuizElement::class);
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