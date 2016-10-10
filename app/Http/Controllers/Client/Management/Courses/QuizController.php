<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Courses;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Module;
use Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\SelectQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\TextQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\DragDropQuestion;
use Pi\Clients\Courses\Quizzes\QuizElementOption;
use Pi\Clients\Courses\Quizzes\Repositories\QuizElementRepository;
use Pi\Http\Controllers\Controller;
use Pi\Clients\Courses\Quizzes\ElementTypes\BaseType;


class QuizController extends Controller
{

    public function create(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId)
    {
        $quizType = $request->get('quizType');
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        if ( ! $article )
            return redirect()->back()->with('message', ['danger', 'Could not find that article.']);

        /** @var Article $article */
        $quiz = $article->quizzes()->create([
            'client_id' => $client->id,
            'created_by' => \Auth::id(),
            'type' => $quizType,
        ]);

        return redirect()->route('clients.manage.courses.modules.articles.quizzes.edit', [$clientSlug, $courseSlug, $moduleSlug, $articleId, $quiz->id]);
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Module), $client]);
        $this->validate($request, Module::rules());
        $module = Module::create($request->all());
        $this->modulesRepository->clearCacheForClient($client);
        return redirect()->route('clients.manage.modules.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new module: '. $module->name.'.']);
    }

    public function edit($clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);

        return view('pages.clients.manage.courses.modules.articles.quizzes.edit', compact('module', 'article', 'quiz', 'course', 'client'));
    }

    /**
     * Updates a Quiz
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);
        $input = $request->all();
        $input['max_attempts'] = ($request->get('max_attempts')) ?: null;
        $quiz->update($input);
        return redirect()->back()->with('message', ['success', 'Successfully updated the quiz.']);
    }

    /**
     * @param Request $request
     * @param $clientSlug
     * @param $courseSlug
     * @param $moduleSlug
     * @param $articleId
     * @param $quizId
     * @param $questionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuestion(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId, $questionId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);

        $question = $quiz->elements()->whereId($questionId)->with('options')->first();
        $question->update([
            'label' => $request->get('body'),
            'answer' => $request->get('answer'),
        ]);
        $options = $request->get('options');

        if ($options && is_array($options)) {
            $answers = [];
            $i = 1;
            foreach($options as $key => $value)
            {
                $existing = preg_match('/existing_(\d*)/', $key, $matches);
                if ($existing) {
                    $option = $question->options()->whereId($matches[1])->firstOrFail();
                }else {
                    $option = new QuizElementOption();
                    $option->client_id = $client->id;
                    $option->quiz_element_id = $question->id;
                    $option->save();
                }
                $option->value = $i;

                if (is_array($value)) {
                    $option->label = $value['label'];
                    if(array_key_exists('isAnswer', $value))
                        $answers[] = $option->value;
                }else {
                    $option->label = $value;
                }


                $option->save();
                $i++;
            }
            if(count($answers)) {
                $question->answer = json_encode($answers);
                $question->save();
            }
        }

        return redirect()->back()->with('message', ['success', 'Successfully updated the question.']);
    }

    public function destroy($clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
//        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
//        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
//        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
//        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        if ( ! $quiz ) return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);

        $quiz->delete();

        return redirect()->back()->with('message', ['success', 'Quiz Deleted']);
    }

    public function postQuestionOrder(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
//        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
//        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
//        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
//        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $elementId)
        {
            $quiz->elements()->whereId($elementId)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $articleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }

    public function addQuestion(Request $request, QuizElementRepository $quizElementRepository, $clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();

        switch($request->get('type')) {
            case (new CheckboxQuestion())->getTypeId():
                $answers = [];
                $options = [];
                foreach($request->get('options') as $number => $option) {
                    $options[] = ['value' => $number, 'label' => $option['label']];
                    if (array_key_exists('isAnswer', $option))
                        $answers[] = $number;
                }
                $answer = json_encode($answers);
                break;

            case (new SelectQuestion)->getTypeId():
                $options = [];
                $answer = $request->get('answer');
                foreach($request->get('options') as $number => $option) {
                    $options[] = ['value' => $number, 'label' => $option['label']];
                }
                break;

            case (new TextQuestion)->getTypeId():
                $options = null;
                $answer = $request->get('answer');
                break;

            case (new DragDropQuestion)->getTypeId():
                if(isset($_GET['files']))
                {  
                    $files = array();
                    $uploaddir = '/assets/uploads/';
                    foreach($_FILES as $file)
                    {
                        if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
                        {
                            $files[] = $uploaddir .$file['name'];
                        }
                    }
                }
                $answers = [];
                $options = [];
                foreach($request->get('options') as $number => $option) {
                    $options[] = ['value' => $number, 'label' => $option['label']];
                    if (array_key_exists('isAnswer', $option))
                        $answers[] = $number;
                }
                $answer = json_encode($answers);
                break;
        }

        $quizElementRepository->createQuestion($client->id, $quiz->id, $request->get('type'), $request->get('body'), $answer, $options);
        return redirect()->back()->with('message', ['success', 'Question added.']);
    }

    public function destroyQuestion(Request $request, QuizElementRepository $quizElementRepository, $clientSlug, $courseSlug, $moduleSlug, $articleId, $quizId, $questionId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->where('modules.slug', $moduleSlug)->with('articles.quizzes')->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $quiz = $article->quizzes()->whereId($quizId)->first();
        $this->authorize('manage', $quiz);
        $question = $quiz->elements()->whereId($questionId)->first();

        if (! $question)
            return response()->json(['success' => false]);

        $question->delete();
        return response()->json(['success' => true]);
    }
}