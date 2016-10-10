<?php
/**
 * Created by Justin McCombs.
 * Date: 10/15/15
 * Time: 3:32 PM
 */

namespace Pi\Http\Controllers\Client;


use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Clients\Courses\Services\UserProgressService;
use Pi\Http\Controllers\Controller;
use Pi\Clients\Client;

class ArticleController extends Controller
{
    public function show(ArticlesService $articlesService, UserProgressService $userProgress, $clientSlug, $courseSlug, $moduleSlug, $articleNumber)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('show', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        $user = \Auth::user();
        $article = $module->articles()->whereNumber($articleNumber)
            ->with([
                'watchActions',
                'listenActions',
                'doQuiz.attempts' => function($q) use($user) {
                    $q->where('user_id', '=', $user->id);
                },
                'answerQuiz.attempts' => function($q) use($user) {
                    $q->where('user_id', '=', $user->id);
                },
            ])
            ->first();
        $this->authorize('show', $article);

        $articlesService->markArticleAsReadForUser($article, \Auth::user());

        $nextArticle = $articlesService->getNextArticleForUser($article, \Auth::user());
        $prevArticle = $articlesService->getPreviousArticleForUser($article, \Auth::user());

        $nextArticleUrl = (!$nextArticle)
            ? null
            : route('clients.courses.modules.articles.show', [
                'clientSlug' => $client->slug,
                'courseSlug' => $course->slug,
                'moduleSlug' => $nextArticle->module->slug,
                'articleNumber' => $nextArticle->number]);

        $prevArticleUrl = (!$prevArticle)
            ? null
            : route('clients.courses.modules.articles.show', [
                'clientSlug' => $client->slug,
                'courseSlug' => $course->slug,
                'moduleSlug' => $prevArticle->module->slug,
                'articleNumber' => $prevArticle->number]);

        return view('pages.clients.courses.modules.articles.show', compact('client', 'course', 'module', 'article', 'nextArticle', 'prevArticle', 'nextArticleUrl', 'prevArticleUrl'));
    }

    public function edit(ArticlesService $articlesService, $clientSlug, $courseSlug, $moduleSlug, $articleNumber)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('show', $course);
        $module = $course->modules()->whereSlug($moduleSlug)->with('articles')->first();
        $this->authorize('show', $module);
        $article = $module->articles()->whereNumber($articleNumber)->first();
        $this->authorize('edit', $article);

        $nextArticle = $articlesService->getNextArticleForUser($article, \Auth::user());
        $prevArticle = $articlesService->getPreviousArticleForUser($article, \Auth::user());

        $nextArticleUrl = (!$nextArticle)
            ? null
            : route('clients.courses.modules.articles.show', [
                'clientSlug' => $client->slug,
                'courseSlug' => $course->slug,
                'moduleSlug' => $nextArticle->module->slug,
                'articleNumber' => $nextArticle->number]);

        $prevArticleUrl = (!$prevArticle)
            ? null
            : route('clients.courses.modules.articles.show', [
                'clientSlug' => $client->slug,
                'courseSlug' => $course->slug,
                'moduleSlug' => $prevArticle->module->slug,
                'articleNumber' => $prevArticle->number]);
        return view('pages.clients.courses.modules.articles.edit', compact('client', 'course', 'module', 'article', 'nextArticle', 'prevArticle', 'nextArticleUrl', 'prevArticleUrl'));
    }


}