<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 4:37 PM
 */

namespace Pi\Clients\Courses\Quizzes\Scoring;


use Illuminate\Events\Dispatcher;
use Pi\Auth\User;
use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Clients\Courses\Quizzes\QuizAttempt;
use Pi\Clients\Courses\Quizzes\QuizElement;
use Pi\Events\Courses\ArticleActionCompleted;

class QuizScoringService
{

    /**
     * @var Dispatcher
     */
    private $events;

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }
    public function scoreQuizForUser(Quiz $quiz, User $user, $input = []) {

        // TODO: Make sure the user can take the test

        $this->validate($quiz, $user, $input);
        $correct = 0;

        foreach($quiz->elements as $quizElement)
        {
            if (array_key_exists($quizElement->input_name, $input)) {
                $value = $input[$quizElement->input_name];
                $isCorrect = $this->scoreQuestion($quizElement, $value);
                $isArray = false;
                if (is_array($value)) {
                    $isArray = true;
                    $value = json_encode($value);
                }

                $quizElement->responses()->create([
                    'client_id' => $quiz->client_id,
                    'user_id' => $user->id,
                    'value' => $value,
                    'is_array' => $isArray,
                    'is_correct' => $isCorrect,
                ]);
                if ($isCorrect) $correct++;
                $storedResponseKeys[] = $quizElement->input_name;
            }
        }

        $this->events->fire('quiz.scored');
        $questions = $this->getQuestions($quiz);
        if ($questions->count() == 0) return 0;
        $score = round($correct/$questions->count()*100, 0);

        $passed = ($score >= $quiz->pass_percentage);
        $attempt = $quiz->attempts()->create([
            'client_id' => $quiz->client_id,
            'user_id' => $user->id,
            'score' => $score,
            'passed' => $passed,
        ]);

        // If quiz was passed, fire the event to update progress
        if ($passed) {
            \Event::fire(new ArticleActionCompleted($user, $quiz->article));
        }


        return $attempt;

    }

    protected function getQuestions(Quiz $quiz)
    {
        return $quiz->elements->filter(function(QuizElement $quizElement) {
            $isQuestion = $quizElement->isQuestion();
            return $isQuestion;
        });
    }

    public function getAttemptsForQuizAndUser(Quiz $quiz, User $user)
    {
        $attempts = $quiz->attempts()->where('user_id', $user->id)->count();
        return $attempts;
    }

    public function getRemainingAttemptsForQuizAndUser(Quiz $quiz, User $user)
    {

        if ($quiz->max_attempts) {
            $attempts = $this->getAttemptsForQuizAndUser($quiz, $user);
            return $quiz->max_attempts - $attempts;
        }
        return 100;

    }

    public function validate(Quiz $quiz, User $user, $input)
    {
        $questions = $this->getQuestions($quiz);
        $missing = array_diff($questions->lists('input_name')->toArray(), array_keys($input));

        if ($quiz->max_attempts)
        {
            $attempts = $this->getAttemptsForQuizAndUser($quiz, $user);
            if ($attempts >= $quiz->max_attempts) {
                throw new \Exception('You have exceeded the number of attempts for this quiz.');
            }
        }

        if (count($missing)) {
            throw new \Exception('You are missing some questions.  Please check your quiz and try again.');
        }

        return true;
    }

    public function scoreQuestion(QuizElement $quizElement, $answer)
    {
        if (is_array($answer)) {
            $correct = json_decode($quizElement->answer);
            return !(count(array_diff($answer, $correct)));
        }else {
            $correct = $quizElement->answer;
            return $correct == $answer;
        }
    }

    public function userHasPassedQuiz(Quiz $quiz, User $user)
    {
        $passed = (bool) $quiz->attempts->filter(function($attempt) use ($user) {
            return ($attempt->user_id == $user->id && $attempt->passed);
        })->count();
        return $passed;
    }

    public function getLastAttemptForQuiz(Quiz $quiz, User $user)
    {
        return $quiz->attempts->filter(function($attempt) use ($user) {
            return ($attempt->user_id == $user->id);
        })->last();
    }

    public function userPercentageForQuiz(Quiz $quiz, User $user)
    {
        $attempt = $this->getLastAttemptForQuiz($quiz, $user);
        if ( ! $attempt ) return 0;
        return $attempt->score;
    }

}