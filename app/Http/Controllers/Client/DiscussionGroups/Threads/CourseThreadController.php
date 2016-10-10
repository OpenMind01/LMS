<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups\Threads;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\CourseRepository as Repo;
use Pi\Utility\Assets\AssetStorageService;
use Illuminate\Http\Request;

class CourseThreadController extends ThreadsBaseController
{
    protected $routePrefix = 'clients.courses.discussions';

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
     * @param $courseSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($clientSlug, $courseSlug, $discussionGroupSlug, $threadSlug)
    {
        return $this->doShow(compact('clientSlug', 'courseSlug', 'discussionGroupSlug', 'threadSlug'));
    }

    /**
     * @param Request $request
     * @param AssetStorageService $assets
     * @param $clientSlug
     * @param $courseSlug
     * @param $discussionGroupSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, AssetStorageService $assets, $clientSlug, $courseSlug, $discussionGroupSlug)
    {
        $storeArgs = compact('clientSlug', 'courseSlug', 'discussionGroupSlug');

        return $this->processStore($request, $assets, $storeArgs);
    }

    /**
     * @param Request $request
     * @param $clientSlug
     * @param $courseSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reply(Request $request, $clientSlug, $courseSlug, $discussionGroupSlug, $threadSlug)
    {
        $storeArgs = compact('clientSlug', 'courseSlug', 'discussionGroupSlug', 'threadSlug');
        return $this->addReply($request, $storeArgs);
    }

    /**
     * @param $clientSlug
     * @param $courseSlug
     * @param $discussionGroupSlug
     * @param $threadSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function raiseHand($clientSlug, $courseSlug, $discussionGroupSlug, $threadSlug)
    {
        return $this->doRaiseHand(compact('clientSlug', 'courseSlug', 'discussionGroupSlug', 'threadSlug'));
    }
}
