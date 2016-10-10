<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Courses;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Actions\ArticleAction;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Http\Controllers\Controller;

class ArticleActionsController extends Controller
{

    public function create($clientSlug, $courseSlug, $moduleSlug, $articleId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);

        $this->addBreadcrumbs($client, $course, $module, $article, 'Create Article Action');

        $actionTypes = ArticleAction::$types;

        return view('pages.clients.manage.courses.modules.articles.actions.create', compact('client', 'course', 'module', 'article', 'actionTypes'));
    }

    public function store(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);

        $this->validate($request, ArticleAction::$rules);

        $action = $article->actions()->create($request->except(['article_id']));

        return redirect()->route('clients.courses.modules.articles.edit', ['clientSlug' => $clientSlug, $course->slug, $module->slug, $article->number])->with('message', ['success', 'Successfully created a new article action.']);
    }

    public function edit($clientSlug, $courseSlug, $moduleSlug, $articleId, $actionId)
    {

        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $articleAction = $article->actions()->whereId($actionId)->first();
        if ( ! $articleAction ) return redirect()->back()->with('message', ['danger', 'Could not find that article action.']);

        $this->addBreadcrumbs($client, $course, $module, $article, 'Edit Article Action');

        $actionTypes = ArticleAction::$types;

        return view('pages.clients.manage.courses.modules.articles.actions.edit', compact('article', 'module', 'course', 'client', 'articleAction', 'actionTypes'));
    }

    /**
     * Updates a Article
     * @param Request $request
     * @param $clientSlug
     * @param $courseSlug
     * @param $moduleSlug
     * @param $articleId
     * @param $actionId
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $id
     */
    public function update(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId, $actionId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $articleAction = $article->actions()->whereId($actionId)->first();
        if ( ! $articleAction ) return redirect()->back()->with('message', ['danger', 'Could not find that article action.']);

        $this->validate($request, ArticleAction::$rules);

        $input = $request->all();

        // If no new file, do not clear it out.
        if ( ! $request->hasFile('file') )
            unset($input['file']);

        $articleAction->update($input);

        return redirect()->route('clients.courses.modules.articles.edit', [$clientSlug, $courseSlug, $moduleSlug, $article->number])->with('message', ['success', 'Successfully updated the article action.']);
    }

    public function destroy(Request $request, $clientSlug, $courseSlug, $moduleSlug, $articleId, $actionId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        $this->authorize('manage', $module);
        $article = $module->articles()->whereId($articleId)->first();
        $this->authorize('manage', $article);
        $articleAction = $article->actions()->whereId($actionId)->first();
        if ( ! $articleAction ) return redirect()->back()->with('message', ['danger', 'Could not find that article action.']);

        $articleAction->delete();

        return redirect()->route('clients.courses.modules.articles.edit', [$clientSlug, $courseSlug, $moduleSlug, $article->number])->with('message', ['success', 'Successfully deleted the article action.']);
    }


    private function addBreadcrumbs(Client $client, Course $course, Module $module, Article $article, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addManagementCourseLink($course, $client);
        $this->breadcrumbsHelper->addManagementModuleLink($module, $course, $client);
        $this->breadcrumbsHelper->addManagementArticleLink($article, $module, $course, $client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}