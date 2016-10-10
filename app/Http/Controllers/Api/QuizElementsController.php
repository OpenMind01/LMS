<?php
/**
 * Created by Justin McCombs.
 * Date: 11/12/15
 * Time: 3:56 PM
 */

namespace Pi\Http\Controllers\Api;


use Pi\Clients\Courses\Quizzes\QuizElement;
use Pi\Http\Controllers\Controller;

class QuizElementsController extends Controller
{

    public function show($questionId)
    {
        $question = QuizElement::with('options')->whereId($questionId)->firstOrFail();

        return $question;
    }

}