<?php

namespace Pi\Events\Courses;

use Pi\Auth\User;
use Pi\Clients\Courses\Article;
use Pi\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleActionCompleted extends Event
{
    use SerializesModels;
    /**
     * @var User
     */
    public $user;
    /**
     * @var Article
     */
    public $article;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Article $article
     */
    public function __construct(User $user, Article $article)
    {
        //
        $this->user = $user;
        $this->article = $article;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
