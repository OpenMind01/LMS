<?php

namespace Pi\Listeners\Courses;

use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Clients\Courses\Services\UserProgressService;
use Pi\Events\Courses\ArticleActionCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckForArticleCompletion
{
    /**
     * @var UserProgressService
     */
    private $userProgressService;
    /**
     * @var ArticlesService
     */
    private $articlesService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserProgressService $userProgressService, ArticlesService $articlesService)
    {
        //
        $this->userProgressService = $userProgressService;
        $this->articlesService = $articlesService;
    }

    /**
     * Handle the event.
     *
     * @param  ArticleActionCompleted  $event
     * @return void
     */
    public function handle(ArticleActionCompleted $event)
    {
        $this->userProgressService->getCourseCompletionPercentageForUser($event->article->module->course, $event->user, true);
    }
}
