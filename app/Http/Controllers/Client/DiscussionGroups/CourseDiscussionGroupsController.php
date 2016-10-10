<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups;

use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\CourseRepository as Repo;

class CourseDiscussionGroupsController extends DiscussionGroupsBaseController
{
    protected $routePrefix = 'clients.courses.discussions';

    /**
     * @var Repo
     */
    protected $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
        parent::__construct($repo);
    }
}
