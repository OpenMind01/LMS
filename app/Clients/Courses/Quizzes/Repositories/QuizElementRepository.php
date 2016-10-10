<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 2:37 PM
 */

namespace Pi\Clients\Courses\Quizzes\Repositories;


use Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion;
use Pi\Clients\Courses\Quizzes\QuizElement;
use Pi\Clients\Courses\Quizzes\ElementTypes\BaseType;

class QuizElementRepository
{

    public function createQuestion($clientId, $quizId, $typeId, $body, $answer, $options = null)
    {
        $question = QuizElement::create([
            'client_id' => $clientId,
            'quiz_id' => $quizId,
            'type' => $typeId,
            'label' => $body,
            'answer' => $answer
        ]);

        if ($options) {
            switch($typeId)
            {
                default:
                    foreach($options as $option) {
                        $question->options()->create([
                            'client_id' => $clientId,
                            'value' => $option['value'],
                            'label' => $option['label'],
                        ]);
                    }
                    break;
            }
        }
    }

}