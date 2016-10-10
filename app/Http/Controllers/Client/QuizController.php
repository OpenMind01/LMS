<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 4:15 PM
 */

namespace Pi\Http\Controllers\Client;


use Illuminate\Http\Request;
use Pi\Clients\Courses\Quizzes\Scoring\QuizScoringService;
use Pi\Http\Controllers\Controller;
use Pi\Clients\Client;
use Pi\Clients\Courses\Quizzes\Quiz;

class QuizController extends Controller
{

    public function show(QuizScoringService $quizScoringService, $clientSlug, $courseSlug, $moduleSlug, $articleNumber, $quizId)
    {

        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        $article = $module->articles()->whereNumber($articleNumber)->first();
        $this->authorize('show', $article);
        $quiz = $article->quizzes()->whereId($quizId)->with('elements.options')->first();

        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find that quiz.']);

        if ( ! $quizScoringService->getRemainingAttemptsForQuizAndUser($quiz, \Auth::user()))
            return redirect()->back()->with('message', ['danger', 'You have no remaining attempts at this quiz.']);

        if ($quizScoringService->userHasPassedQuiz($quiz, \Auth::user())) {
            return redirect()->back()->with('message', ['success', 'You have already completed this quiz!']);
        }

        return view('pages.clients.courses.modules.articles.quizzes.show', compact('client', 'course', 'module', 'article', 'quiz'));

    }

    public function update(Request $request, QuizScoringService $quizScoringService, $clientSlug, $courseSlug, $moduleSlug, $articleNumber, $quizId) {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        $article = $module->articles()->whereNumber($articleNumber)->first();
        $this->authorize('show', $article);
        $quiz = $article->quizzes()->whereId($quizId)->with('elements.options')->first();

        try {
            $attempt = $quizScoringService->scoreQuizForUser($quiz, \Auth::user(), $request->except('_token'));
        }catch (\Exception $e) {
            return redirect()->back()->with('message', ['danger', $e->getMessage()])->withInput($request->all());
        }

        if ($attempt->passed)
        {
            return redirect()->route('clients.courses.modules.articles.show', [$client->slug, $course->slug, $module->slug, $article->number])->with('message', ['success', 'Congratulations, you passed the test with a score of ' . $attempt->score . '%!' ]);
        }else {
            $remainingAttempts = $quizScoringService->getRemainingAttemptsForQuizAndUser($quiz, \Auth::user());
            if (!$remainingAttempts) {
                return redirect()->route('clients.courses.modules.articles.show', [$client->slug, $course->slug, $module->slug, $article->number])->with('message', ['danger', 'Unfortunately, you did not pass the test with a score of ' . $attempt->score . '%.  You have ' . $remainingAttempts . ' tries left.' ]);
            }else {
                return redirect()->route('clients.courses.modules.articles.show', [$client->slug, $course->slug, $module->slug, $article->number])->with('message', ['danger', 'Unfortunately, you did not pass the test with a score of ' . $attempt->score . '%.  Please Try Again.' ]);
            }


        }
    }

    public function showQuizAttempt($clientSlug, $courseSlug, $moduleSlug, $articleNumber, $quizId, $attemptId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        $user = \Auth::user();
        $article = $module->articles()->whereNumber($articleNumber)
            ->first();

        $quiz = Quiz::where('client_id', '=', $client->id)
            ->whereId($quizId)
            ->with(['elements', 'responses' => function($q) use ($user) {
                $q->where('user_id', '=', $user->id)->with('quizElement.options');
            }])
            ->first();
        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);

        $attempt = $quiz->attempts()->whereId($attemptId);


        return view('pages.clients.courses.modules.articles.quizzes.show-attempt', compact('client', 'module', 'article', 'course', 'user', 'quiz', 'attempt'));

    }

}