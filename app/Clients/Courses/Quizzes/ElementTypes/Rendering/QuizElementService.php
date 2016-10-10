<?php
/**
 * Created by Justin McCombs.
 * Date: 11/3/15
 * Time: 4:45 PM
 */

namespace Pi\Clients\Courses\Quizzes\ElementTypes\Rendering;


use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Clients\Courses\Quizzes\QuizElement;
use Illuminate\Support\Collection;
use Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\SelectQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\TextQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\DragDropQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\TextSection;
use Pi\Clients\Courses\Quizzes\ElementTypes\Interfaces\QuizElementTypeInterface;


class QuizElementService
{

    /**
     * Register all quiz types here
     * @var array
     */
    protected $types = [
        CheckboxQuestion::class,
        SelectQuestion::class,
        TextQuestion::class,
        TextSection::class,
        DragDropQuestion::class,
    ];

    /**
     * @var Collection
     */
    protected $typeInstances;

    public function __construct()
    {
        $this->typeInstances= new Collection();
        foreach($this->types as $className)
        {
            /** @var QuizElementTypeInterface $instance */
            $instance = new $className;
            $this->typeInstances->put($instance->getTypeId(), $instance);
        }
    }

    public function render(QuizElement $quizElement)
    {
        $elementType = $this->getElementType($quizElement);

        return $elementType->render($quizElement);
    }

    public function getElementType(QuizElement $quizElement)
    {
        foreach($this->typeInstances as $instance)
        {
            /** @var QuizElementTypeInterface $instance */
            if ($instance->getTypeId() == $quizElement->type)
                return $instance;
        }
        throw new \Exception('Cannot find a type with the key ' . $quizElement->type);
    }

    public function elementIsQuestion(QuizElement $quizElement)
    {
        $type = $this->getElementType($quizElement);
        return $type->isQuestion();
    }

}