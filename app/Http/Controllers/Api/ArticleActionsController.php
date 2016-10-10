<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 4:54 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Actions\ArticleAction;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Services\ArticleActionService;
use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Http\Controllers\Controller;

class ArticleActionsController extends ApiController
{

    public function markComplete(ArticleActionService $articleActionService, $articleId, $actionId)
    {
        $action = ArticleAction::find($actionId);
        if ( ! $action ) return $this->responseError('Could not find the article action.');
        $this->authorize('read', $action->article);
        $articleActionService->markActionAsCompleteForUser($action, \Auth::user());
        return $this->responseSuccess('Article Action marked as complete.');

    }

    public function markIncomplete(ArticleActionService $articleActionService, $articleId, $actionId)
    {
        $action = ArticleAction::find($actionId);
        if ( ! $action ) return $this->responseError('Could not find the article action.');
        $this->authorize('read', $action->article);
        $articleActionService->markActionAsIncompleteForUser($action, \Auth::user());
        return $this->responseSuccess('Article Action marked as incomplete.');

    }

}