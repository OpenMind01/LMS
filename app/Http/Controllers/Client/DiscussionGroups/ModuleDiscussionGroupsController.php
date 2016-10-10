<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups;

use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ModuleDiscussionGroupRepository as Repo;

class ModuleDiscussionGroupsController extends DiscussionGroupsBaseController
{
    protected $routePrefix = 'clients.courses.modules.discussions';

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
