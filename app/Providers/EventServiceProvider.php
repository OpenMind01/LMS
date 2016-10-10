<?php

namespace Pi\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Pi\Events\Courses\ArticleActionCompleted;
use Pi\Listeners\Courses\CheckForArticleCompletion;
use Pi\Listeners\Courses\UpdateUserCourses;
use Pi\Listeners\MailSender;
use Pi\Listeners\Milestones\UpdateUserMilestones;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ArticleActionCompleted::class => [
            CheckForArticleCompletion::class,
        ],
    ];

    protected $subscribe = [
        UpdateUserMilestones::class,
        MailSender::class,
        UpdateUserCourses::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $events->listen('auth.login', function ($user) {
            $user->logged_in = new \DateTime('now');
            $user->save();
        });

        $events->listen('auth.logout', function ($user) {
            $user->logged_out = new \DateTime('now');
            $user->save();
        });
    }
}
