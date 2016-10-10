<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups\Threads;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ClientRepository as Repo;
use Pi\Utility\Assets\AssetStorageService;
use Illuminate\Http\Request;

class ClientThreadController extends ThreadsBaseController
{
    protected $routePrefix = 'clients.discussions';

    /**
     * @var Repo
     */
    protected $repo;

    /**
     * @param Repo $repo
     */
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
        parent::__construct($repo);
    }

    /**
     * @param $clientSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($clientSlug, $discussionGroupSlug, $threadSlug)
    {
        return $this->doShow(compact('clientSlug', 'discussionGroupSlug', 'threadSlug'));
    }

    /**
     * @param Request $request
     * @param AssetStorageService $assets
     * @param $clientSlug
     * @param $discussionGroupSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, AssetStorageService $assets, $clientSlug, $discussionGroupSlug)
    {
        $storeArgs = compact('clientSlug', 'discussionGroupSlug');


        return $this->processStore($request, $assets, $storeArgs);
    }

    /**
     * @param Request $request
     * @param $clientSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reply(Request $request, $clientSlug, $discussionGroupSlug, $threadSlug)
    {
        $storeArgs = compact('clientSlug', 'discussionGroupSlug', 'threadSlug');
        return $this->addReply($request, $storeArgs);
    }

    /**
     * @param $clientSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function raiseHand($clientSlug, $discussionGroupSlug, $threadSlug)
    {
        return $this->doRaiseHand(compact('clientSlug', 'discussionGroupSlug', 'threadSlug'));
    }
}
