<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:30 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes;
use Pi\Clients\Courses\Quizzes\QuizElement;

class SelectQuestion extends BaseType
{
    protected $typeId = 2;
    protected $name = 'Question: Select Box';
    protected $iconClass = 'fa-question-mark';

    public function render(QuizElement $quizElement = null)
    {
        if ( ! $quizElement )
            $quizElement = new QuizElement();

        $typeClass = $this;

        return view('quiz-elements.user.select', compact('quizElement', 'typeClass'));
    }
}