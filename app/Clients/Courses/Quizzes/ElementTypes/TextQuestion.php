<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:17 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes;

use Pi\Clients\Courses\Quizzes\QuizElement;
class TextQuestion extends BaseType
{
    protected $typeId = 3;
    protected $name = 'Question: Text Box';
    protected $iconClass = 'fa-question-mark';

    public function render(QuizElement $quizElement = null)
    {
        if ( ! $quizElement )
            $quizElement = new QuizElement();

        $typeClass = $this;

        return view('quiz-elements.user.text', compact('quizElement', 'typeClass'));
    }
}