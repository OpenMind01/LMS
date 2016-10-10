<?php

namespace Pi\Policies;

use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Repositories\CourseUserRepository;

class ArticlePolicy
{
    /**
     * @var CourseUserRepository
     */
    private $courseUsers;

    /**
     * Create a new policy instance.
     *
     * @param CourseUserRepository $courseUsers
     */
    public function __construct(CourseUserRepository $courseUsers)
    {
        $this->courseUsers = $courseUsers;
    }

    public function show(User $user, Article $article)
    {
        if ($user->isModerator()) return true;

        if ($user->isStudent() && $this->courseUsers->userBelongsToCourse($user, $article->getCourse()))
            return true;

        return false;
    }

    public function edit(User $user, Article $article)
    {
        if ($user->isModerator()) return true;

        return false;
    }

    public function read(User $user, Article $article)
    {
        if ($this->courseUsers->userBelongsToCourse($user, $article->module->course))
            return true;

        return false;
    }

    public function manage(User $user, Article $article)
    {
        if ($user->isAdmin()) return true;

        if ($user->client_id == $article->client_id && in_array($user->role, [Role::ADMIN]))
            return true;

        return false;
    }
}
