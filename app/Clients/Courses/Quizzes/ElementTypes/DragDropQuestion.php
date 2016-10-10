<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:30 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes;
use Pi\Clients\Courses\Quizzes\QuizElement;

class DragDropQuestion extends BaseType
{
    protected $typeId = 5;
    protected $name = 'Question: Checkbox';
    protected $iconClass = 'fa-question-mark';

    public function render(QuizElement $quizElement = null)
    {
        if ( ! $quizElement )
            $quizElement = new QuizElement();

        $typeClass = $this;

        return view('quiz-elements.user.dragdrop', compact('quizElement', 'typeClass'));
    }
}