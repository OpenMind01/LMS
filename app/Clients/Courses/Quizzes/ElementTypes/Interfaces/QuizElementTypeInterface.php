<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:31 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes\Interfaces;


use Pi\Clients\Courses\Quizzes\QuizElement;

interface QuizElementTypeInterface
{

    /**
     * Returns the unique id of the element type
     * @return int
     */
    public function getTypeId();

    /**
     * Returns the name of the element type (for use in constructing quizzes)
     * @return string
     */
    public function getName();

    /**
     * Returns the CSS class to use for the icon element
     * @return mixed
     */
    public function getIconClass();

    /**
     * Returns a rendering of the element for the BUILDER of the quiz
     *  -- defaults to renderForUser with a blank QuizElement.  only
     *     needs to be overridden if the builder needs a different view
     * @param QuizElement|null $quizElement
     * @return string
     */
    public function renderForBuilder(QuizElement $quizElement = null);

    /**
     * Renders the quiz element as it will appear on the quiz
     * @param QuizElement|null $quizElement
     * @return string
     */
    public function render(QuizElement $quizElement = null);

}