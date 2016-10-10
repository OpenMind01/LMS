<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups;

use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ClientRepository as Repo;

class ClientDiscussionGroupsController extends DiscussionGroupsBaseController
{
    protected $routePrefix = 'clients.discussions';

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
