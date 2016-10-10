<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:17 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes;


use Pi\Clients\Courses\Quizzes\ElementTypes\Interfaces\QuizElementTypeInterface;
use Pi\Clients\Courses\Quizzes\QuizElement;

abstract class BaseType
{

    /**
     * @var int
     */
    protected $typeId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $iconClass;

    /**
     * Returns the unique id of the element type
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Returns the name of the element type (for use in constructing quizzes)
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the CSS class to use for the icon element
     * @return mixed
     */
    public function getIconClass()
    {
        return $this->iconClass;
    }

    /**
     * Returns a rendering of the element for the BUILDER of the quiz
     *  -- defaults to renderForUser with a blank QuizElement.  only
     *     needs to be overridden if the builder needs a different view
     * @param QuizElement|null $quizElement
     * @return string
     */
    public function renderForBuilder(QuizElement $quizElement = null)
    {
        return $this->render($quizElement);
    }

    /**
     * Renders the quiz element as it will appear on the quiz
     * @param QuizElement|null $quizElement
     * @return string
     */
    public function render(QuizElement $quizElement = null)
    {
        return '';
    }

    public function isQuestion()
    {
        $class = get_class($this);

        $nonQuestionClasses = [
            TextSection::class
        ];

        return !in_array($class, $nonQuestionClasses);
    }
}