<?php
/**
 * Created by Justin McCombs.
 * Date: 12/31/15
 * Time: 2:42 PM
 */

namespace Pi\Clients\Courses\Services;


use Pi\Auth\User;
use Pi\Clients\Courses\Actions\ArticleAction;
use Pi\Events\Courses\ArticleActionCompleted;

class ArticleActionService
{

    public function userHasCompletedAction(ArticleAction $action, User $user)
    {
        $count = $action->users->filter(function ($_user) use ($user) {
            return ($_user->id == $user->id && $_user->pivot->completion_percent == 100);
        })->count();
        return  ($count) ? 1 : 0;
    }

    public function markActionAsCompleteForUser(ArticleAction $action, User $user)
    {
        if ( ! $this->userHasCompletedAction($action, $user)) {
            $action->users()->attach($user->id, [
                'client_id' => $user->client_id,
                'completion_percent' => 100
            ]);
        }

        \Event::fire(new ArticleActionCompleted($user, $action->article));
        return $this;
    }

    public function markActionAsIncompleteForUser(ArticleAction $action, User $user)
    {
        if ( $this->userHasCompletedAction($action, $user)) {
            $action->users()->detach($user->id);
        }
        \Event::fire(new ArticleActionCompleted($user, $action->article));
        return $this;
    }

}