<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:31 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes;
use Pi\Clients\Courses\Quizzes\QuizElement;

class TextSection extends BaseType
{
    protected $typeId = 4;
    protected $name = 'Section: Text Area';
    protected $iconClass = 'fa-list';

    public function render(QuizElement $quizElement = null)
    {
        if ( ! $quizElement )
            $quizElement = new QuizElement();

        $typeClass = $this;

        return view('quiz-elements.user.checkbox', compact('quizElement', 'typeClass'));
    }
}