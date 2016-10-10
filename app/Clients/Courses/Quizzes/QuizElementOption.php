<?php
/**
 * Created by Justin McCombs.
 * Date: 10/27/15
 * Time: 4:32 PM
 */

namespace Pi\Clients\Courses\Quizzes;

/**
 * Pi\Clients\Courses\Quizzes\QuizElementOption
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $quiz_element_id
 * @property string $value
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read QuizElement $element
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereQuizElementId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElementOption whereUpdatedAt($value)
 */
class QuizElementOption extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required|integer',
        'quiz_element_id' => 'required|integer',
        'value' => 'required',
        'label' => 'required',
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
    public function element()
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