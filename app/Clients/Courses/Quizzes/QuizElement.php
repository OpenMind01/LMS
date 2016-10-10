<?php
/**
 * Created by Justin McCombs.
 * Date: 10/27/15
 * Time: 4:32 PM
 */

namespace Pi\Clients\Courses\Quizzes;
use Illuminate\Database\Eloquent\Collection;
use Pi\Clients\Courses\Quizzes\ElementTypes\Rendering\QuizElementService;

/**
 * Pi\Clients\Courses\Quizzes\QuizElement
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $quiz_id
 * @property integer $number
 * @property integer $type
 * @property string $label
 * @property string $attributes
 * @property string $answer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Quiz $quiz
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizElementResponse[] $responses
 * @property-read \Illuminate\Database\Eloquent\Collection|QuizElementOption[] $options
 * @property-read mixed $type_name
 * @property-read mixed $input_name
 * @property-read mixed $is_question
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereClientId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereQuizId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereAttributes($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Courses\Quizzes\QuizElement whereUpdatedAt($value)
 */
class QuizElement extends \Eloquent {

    protected $guarded = ['id'];

    public static $rules = [
        'client_id' => 'required|integer',
        'quiz_id' => 'required|integer',
        'type' => 'required',
        'label' => 'required',
    ];

    protected $appends = ['input_name'];

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
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function responses()
    {
        return $this->hasMany(QuizElementResponse::class);
    }

    public function options()
    {
        return $this->hasMany(QuizElementOption::class);
    }

    /*
	|--------------------------------------------------------------------------
	| Getters and Setters
	|--------------------------------------------------------------------------
	*/
    public function getTypeNameAttribute()
    {
        $qes = \App::make(QuizElementService::class);
        return $qes->getElementType($this)->getName();
    }

    public function getInputNameAttribute()
    {
        return 'element_'.$this->id;
    }

    public function getIsQuestionAttribute()
    {
        return $this->isQuestion();
    }



    /*
	|--------------------------------------------------------------------------
	| Repo Methods
	|--------------------------------------------------------------------------
    | These methods may be moved to a repository later on in the development
    | cycle as needed.
	*/
    public function isQuestion()
    {
        $qes = \App::make(QuizElementService::class);
        return $qes->elementIsQuestion($this);
    }

}
QuizElement::creating(function(QuizElement $element) {
    $count = QuizElement::where('quiz_id', $element->quiz_id)->count();
    $element->number = $count + 1;
});

QuizElement::deleting(function(QuizElement $element) {
    $element->options()->delete();
    $element->responses()->delete();
});