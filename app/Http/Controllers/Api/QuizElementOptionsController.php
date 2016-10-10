<?php
/**
 * Created by Justin McCombs.
 * Date: 11/12/15
 * Time: 3:56 PM
 */

namespace Pi\Http\Controllers\Api;


use Pi\Clients\Courses\Quizzes\QuizElement;
use Pi\Clients\Courses\Quizzes\QuizElementOption;
use Pi\Http\Controllers\Controller;

class QuizElementOptionsController extends Controller
{

    public function show($optionId)
    {
        $option = QuizElementOption::whereId($optionId)->firstOrFail();

        return $option;
    }

    public function destroy($optionId)
    {
        $option = QuizElementOption::whereId($optionId)->firstOrFail();
        $option->delete();
        return response()->json(['success' => true]);
    }

}