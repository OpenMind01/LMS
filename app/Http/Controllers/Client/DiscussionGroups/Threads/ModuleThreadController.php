<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups\Threads;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ModuleDiscussionGroupRepository as Repo;
use Pi\Utility\Assets\AssetStorageService;
use Illuminate\Http\Request;

class ModuleThreadController extends ThreadsBaseController
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

    public function show(
        $clientSlug,
        $courseSlug,
        $moduleSlug,
        $discussionGroupSlug,
        $threadSlug)
    {
        return $this->doShow(compact('clientSlug', 'courseSlug', 'moduleSlug', 'discussionGroupSlug', 'threadSlug'));
    }

    public function store(
        Request $request,
        AssetStorageService $assets,
        $clientSlug,
        $courseSlug,
        $moduleSlug,
        $discussionGroupSlug
    )
    {
        $storeArgs = compact('clientSlug', 'courseSlug', 'moduleSlug', 'discussionGroupSlug');

        return $this->processStore($request, $assets, $storeArgs);
    }

    /**
     * @param Request $request
     * @param $clientSlug
     * @param $courseSlug
     * @param $moduleSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reply(Request $request, $clientSlug, $courseSlug, $moduleSlug, $discussionGroupSlug, $threadSlug)
    {
        $storeArgs = compact('clientSlug', 'courseSlug', 'moduleSlug', 'threadSlug', 'discussionGroupSlug');
        return $this->addReply($request, $storeArgs);
    }

    /**
     * @param $clientSlug
     * @param $discussionGroupSlug
     * @param $courseSlug
     * @param $moduleSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function raiseHand($clientSlug, $courseSlug, $moduleSlug, $discussionGroupSlug, $threadSlug)
    {
        return $this->doRaiseHand(compact('clientSlug', 'courseSlug', 'moduleSlug', 'threadSlug', 'discussionGroupSlug'));
    }
}
