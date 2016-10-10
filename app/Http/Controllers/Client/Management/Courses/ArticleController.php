<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Courses;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Http\Controllers\Controller;

class ArticleController extends Controller
{

    public function create($clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);

        $this->addBreadcrumbs($client, $course, $module, 'Create article');

        return view('pages.clients.manage.courses.modules.articles.create', compact('client', 'course', 'module'));
    }

    public function store(Request $request, $clientSlug, $courseSlug, $moduleSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $article = $module->articles()->create($request->all());
        return redirect()->route('clients.manage.courses.modules.edit', ['clientSlug' => $clientSlug, $course->slug, $module->slug])->with('message', ['success', 'Successfully created a new article: '. $article->name.'.']);
    }

    public function edit($clientSlug, $courseSlug, $moduleSlug, $articleId)
    {

        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->where('articles.id', $articleId)->with('doQuiz', 'answerQuiz')->first();
        $this->authorize('manage', $article);

        $this->addBreadcrumbs($client, $course, $module, 'Edit article #' . $article->number);

        return redirect()->route('clients.courses.modules.articles.edit', [$clientSlug, $courseSlug, $moduleSlug, $article->number]);
    }

    /**
     * Updates a Article
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $article = $client->articles()->whereId($id)->first();
        if ( ! $article )
            return redirect()->back()->with('message', ['danger', 'Could not find the article.']);
        $this->authorize('manage', $article);
        $this->validate($request, Article::rules($article));
        $article->update($request->all());
        return redirect()->route('clients.manage.articles.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the article '.$article->name.'.']);
    }

    public function destroy($clientSlug, $courseSlug, $moduleSlug, $articleId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->where('articles.id', $articleId)->with('doQuiz', 'answerQuiz')->first();
        if ( ! $article )
            return redirect()->back()->with('message', ['danger', 'Could not find the article.']);
        $article->delete();
        return redirect()->back()->with('message', ['warning', 'Article was removed.']);
    }

    public function postArticleOrder(Request $request, $clientSlug, $articleId, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $article = Article::find($articleId);
        $this->authorize('manage', [$article, $client]);
        if ( ! $article )
            return response()->json(['success' => false]);
        $article = $article->articles()->whereId($id)->first();
        $this->authorize('manage', $article);

        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $articleId)
        {
            $article->articles()->whereId($id)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $articleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }

    public function mostRecent()
    {
        $client = \Auth::user()->client;
        //@todo this needs to be modified to take the user to the course that is appropriate
        $course = Course::where('id','=','27')->first();
        $module = Module::where('id','=','96')->first();

        return redirect()->route('clients.courses.modules.articles.show', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug, 'moduleSlug' => $module->slug, 'articleNumber' => 1]);
    }



    private function addBreadcrumbs(Client $client, Course $course, Module $module, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addManagementCourseLink($course, $client);
        $this->breadcrumbsHelper->addManagementModuleLink($module, $course, $client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}