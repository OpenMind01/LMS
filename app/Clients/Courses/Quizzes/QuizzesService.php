<?php

namespace Pi\Clients\Courses\Quizzes;

use Pi\Clients\Courses\Article;

class QuizzesService
{
    /**
     * Clones quiz into new article
     *
     * @param Quiz $quiz
     * @param Article $parent
     * @returns Quiz
     */
    public function cloneQuiz(Quiz $quiz, Article $parent)
    {
        $newQuiz = new Quiz();
        $newQuiz->client_id = $parent->client_id;
        $newQuiz->article_id = $parent->id;
        $newQuiz->created_by = $quiz->created_by;
        $newQuiz->type = $quiz->type;
        $newQuiz->name = $quiz->name;
        $newQuiz->description = $quiz->description;
        $newQuiz->max_attempts = $quiz->max_attempts;
        $newQuiz->pass_percentage = $quiz->pass_percentage;

        $newQuiz->save();

        foreach($quiz->elements as $element)
        {
            $this->cloneQuizElement($element, $newQuiz);
        }

        return $newQuiz;
    }

    private function cloneQuizElement(QuizElement $element, Quiz $parent)
    {
        $newElement = new QuizElement();
        $newElement->client_id = $parent->client_id;
        $newElement->quiz_id = $parent->id;
        $newElement->type = $element->type;
        $newElement->label = $element->label;
        $newElement->attributes = $element->attributes;
        $newElement->answer = $element->answer;

        $newElement->save();

        foreach($element->options as $option)
        {
            $this->cloneQuizElementOption($option, $newElement);
        }

        return $newElement;
    }

    private function cloneQuizElementOption(QuizElementOption $option, QuizElement $parent)
    {
        $newOption = new QuizElementOption();
        $newOption->client_id = $parent->client_id;
        $newOption->quiz_element_id = $parent->id;
        $newOption->value = $option->value;
        $newOption->label = $option->label;

        $newOption->save();

        return $newOption;
    }
}