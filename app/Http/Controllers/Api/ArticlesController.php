<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 4:54 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Http\Controllers\Controller;

class ArticlesController extends ApiController
{

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $this->authorize('manage', $article);

        if ( $request->has('pk')) {
            return $this->updateInlineEditable($request, $id, $article);
        }
        dd($request->all());
    }

    public function inlineUpdate(Request $request, $id)
    {

        $article = Article::find($id);

        if ( ! $article )
            return response()->json(['success' => false]);

        $this->authorize('manage', $article);

        $attributes = [];

        foreach(json_decode($request->get('raptor-content')) as $field => $value)
        {
            $attributes[$field] = $value;
        }

        $newArticle = $article->createNewVersion($attributes);



        return response()->json([
            'success' => true,
            'article' => $newArticle,
        ]);
    }

    public function markRead(ArticlesService $articlesService, $articleId)
    {
        $article = Article::find($articleId);
        $this->authorize('read', $article);
        $articlesService->markArticleAsReadForUser($article, \Auth::user());
        return $this->responseSuccess('Article marked as read.');

    }

}