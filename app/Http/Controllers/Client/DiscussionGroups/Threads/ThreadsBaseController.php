<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups\Threads;

use Pi\DiscussionGroups\DiscussionGroupThread;
use Pi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pi\Utility\Assets\AssetStorageService;
use Pi\DiscussionGroups\DiscussionGroupPost as Post;
use Pi\Auth\Permission;
use Pi\Mail\Mailer;

/**
 * Class ThreadsBaseController
 * @package Pi\Http\Controllers\Client\DiscussionGroups\Threads
 *
 * @TODO: Write some tests and refactor this class
 */
abstract class ThreadsBaseController extends Controller
{
    protected $routePrefix;

    /**
     * @var Repo
     */
    protected $repo;

    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $args
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function doShow($args)
    {
        $clientSlug = $args['clientSlug'];
        $discussionGroupSlug = $args['discussionGroupSlug'];
        $threadSlug = $args['threadSlug'];

        $discussionable = $this->repo->getDiscussionableFromArgs($args);
        $discussionGroups = $discussionable->discussionGroups;
        $currentDiscussionGroup = $discussionGroups->filter(function($item) use ($discussionGroupSlug) {
            return $item->slug == $discussionGroupSlug;
        })->first();

        if (!$currentDiscussionGroup) {
            return redirect(route('clients.discussions.index', compact('clientSlug')));
        }

        $thread = $currentDiscussionGroup->threads()->with('posts')->whereSlug($threadSlug)->first();

        if (!$thread) {
            return redirect(route('clients.discussions.index', compact('clientSlug')));
        }

        $routeParameters = array_values($args);
        $routePrefix = $this->routePrefix;

        return view('pages.clients.discussions.thread', compact('thread', 'discussionGroups', 'routePrefix', 'routeParameters'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $args = func_get_args();
        $discussionable = call_user_func_array([$this->repo, 'getDiscussionable'], $args);

        $discussionGroupSlug = last($args);

        $discussionGroups = $discussionable->discussionGroups;
        $currentDiscussionGroup = $discussionGroups->filter(function($item) use ($discussionGroupSlug) {
            return $item->slug == $discussionGroupSlug;
        })->first();

        $routeParameters = $args;
        $routePrefix = $this->routePrefix;
        return view('pages.clients.discussions.thread-create', compact('currentDiscussionGroup', 'discussionGroups', 'routePrefix', 'routeParameters'));
    }

    /**
     * Does the actual store in the DB
     *
     * @param Request $request
     * @param AssetStorageService $assets
     * @param $args
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function processStore(Request $request, AssetStorageService $assets, array $args)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        // clientSlug and discussionGroupslug are always gonna be present
        $clientSlug = $args['clientSlug'];
        $discussionGroupSlug = $args['discussionGroupSlug'];

        $discussionGroup = $this->loadDiscussionGroup($discussionGroupSlug, $args);

        if (!$discussionGroup) {
            return redirect(route('clients.discussions.index', compact('clientSlug')));
        }

        $post = $this->repo->addThreadFromRequest($discussionGroup, $request);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $assets->addFileToAssetable($file, $post);
        }

        $routeParameters = $this->getRouteParameters($args);
        $routeParameters[] = $post->thread->slug;

        return redirect(route($this->routePrefix . '.threads.show', $routeParameters));
    }

    /**
     * @param Request $request
     * @param array $args
     */
    protected function addReply(Request $request, array $args)
    {
        $this->validate($request, [
            'body'
        ]);

        $clientSlug = $args['clientSlug'];
        $discussionGroupSlug = $args['discussionGroupSlug'];
        $threadSlug = $args['threadSlug'];

        $discussionGroup = $this->loadDiscussionGroup($discussionGroupSlug, $args);

        if (!$discussionGroup) {
            return redirect(route('clients.discussions.index', compact('clientSlug')));
        }

        /**
         * @var $thread DiscussionGroupThread
         */
        $thread = $discussionGroup->threads()->whereSlug($threadSlug)->firstOrFail();

        $thread->posts()->create([
            'body' => $request->input('body'),
            'type',
            'user_id' => \Auth::user()->id,
            'type' => Post::TYPE_ANSWER,
            'client_id' => $discussionGroup->client_id
        ]);

        $routeParameters = $this->getRouteParameters($args);
        $routeParameters[] = $thread->slug;

        return redirect(route($this->routePrefix . '.threads.show', $routeParameters));
    }

    /**
     * Calls the repo to load a single discussion group
     *
     * @param $discussionGroupSlug
     * @param $searchParams
     * @return \Pi\DiscussionGroups\DiscussionGroup
     * @throws \Exception
     */
    protected function loadDiscussionGroup($discussionGroupSlug, $args)
    {
        $discussionable = $this->repo->getDiscussionableFromArgs($args);

        if (!$discussionable) {
            throw new \Exception('Not a valid discussionable');
        }

        $discussionGroup = $discussionable->discussionGroups->filter(function($item) use ($discussionGroupSlug) {
            return $item->slug == $discussionGroupSlug;
        })->first();

        return $discussionGroup;
    }

    /**
     * As this controller is used at the client/course/module level, each one of them has
     * it's own set of url parameters.
     * - client just has clientSlug, course has clientSlug and courseSlug... and so on
     *
     * @param array $args
     * @return array
     */
    protected function getRouteParameters(array $args)
    {
        $routeParams = [
            $args['clientSlug']
        ];

        if (isset($args['courseSlug'])) {
            $routeParams[] = $args['courseSlug'];

            if (isset($args['moduleSlug'])) {
                $routeParams[] = $args['moduleSlug'];
            }
        }

        if (isset($args['discussionGroupSlug'])) {
            $routeParams[] = $args['discussionGroupSlug'];
        }

        return $routeParams;
    }

    protected function doRaiseHand($args)
    {
        $this->authorize(Permission::THREAD_RAISE_HAND);

        $clientSlug = $args['clientSlug'];
        $discussionGroupSlug = $args['discussionGroupSlug'];
        $threadSlug = $args['threadSlug'];

        $discussionGroup = $this->loadDiscussionGroup($discussionGroupSlug, $args);

        if (!$discussionGroup) {
            return redirect(route('clients.discussions.index', compact('clientSlug')));
        }

        /**
         * @var $thread DiscussionGroupThread
         */
        $thread = $discussionGroup->threads()->whereSlug($threadSlug)->firstOrFail();

        $admin = $thread->client->administrator;
        $moderator = \Auth::user();

        /**
         * @var $mailer Mailer
         */
        $mailer = \App::make(Mailer::class);
        $mailer->send(
            'raise-hand-notification',
            $admin->email,
            [
                'admin_full_name' => $admin->fullName,
                'moderator_full_name' => $moderator->fullName,
                'student_full_name' => $thread->user->fullName,
                'thread_title' => $thread->title,
                'thread_slug' => $thread->slug,
            ]
        );

        $thread->hand_raised = true;
        $thread->save();

        $routeParameters = $this->getRouteParameters($args);
        $routeParameters[] = $thread->slug;

        return redirect(route($this->routePrefix . '.threads.show', $routeParameters));
    }
}
