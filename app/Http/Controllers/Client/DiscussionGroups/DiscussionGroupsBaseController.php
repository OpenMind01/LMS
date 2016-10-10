<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/11/15
 * Time: 5:23 PM
 */

namespace Pi\Http\Controllers\Client\DiscussionGroups;

use Pi\Auth\Role;
use Pi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pi\Helpers\SlugHelper;
use Pi\Auth\Permission;

/**
 * Class BaseController
 * @package Pi\Http\Controllers\Client\DiscussionGroups
 */
abstract class DiscussionGroupsBaseController extends Controller
{
    protected $routePrefix = null;

    /**
     */
    protected $repo;

    /**
     * @param $repo
     */
    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index($clientSlug)
    {
        $args = func_get_args();
        $discussionGroups = call_user_func_array([$this->repo, 'getDiscussions'], $args);
        $routeParameters = $args;
        $routePrefix  = $this->routePrefix;
        $currentDiscussionGroup = $discussionGroups->first();

        if (!$currentDiscussionGroup) {
            if (\Auth::user()->role == Role::STUDENT) {
                // can't redirect->back() because if the url is accessed directly, this is gonna give a redirect loop
                return redirect('/')->with('message', ['danger', 'No discussion groups']);
            } else {
                return redirect(route($routePrefix . '.create', $routeParameters));
            }
        }

        return view('pages.clients.discussions.index', compact('currentDiscussionGroup', 'discussionGroups', 'routePrefix', 'routeParameters'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize(Permission::DISCUSSION_GROUPS_MANAGE);

        $args = func_get_args();
        $routeParameters = $args;
        $routePrefix  = $this->routePrefix;

        return view('pages.clients.discussions.create', compact('routePrefix', 'routeParameters'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize(Permission::DISCUSSION_GROUPS_MANAGE);

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $args = func_get_args();
        /**
         * @var $request Request
         */
        $request = array_shift($args);
        $routeParameters = $args;

        $discussionable = call_user_func_array([$this->repo, 'getDiscussionable'], $args);

        $discussionable->discussionGroups()->create([
            'client_id' => $discussionable->client_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => SlugHelper::generate($request->input('title'), $discussionable->discussionGroups->lists('slug')->toArray())
        ]);

        return redirect(route($this->routePrefix . '.index', $routeParameters));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show()
    {

        $args = func_get_args();
        $discussionGroups = call_user_func_array([$this->repo, 'getDiscussions'], $args);

        if (!$discussionGroups) {
            // @TODO: Where should I redirect to?
            return redirect('/');
        }

        $discussionGroupSlug = array_pop($args);

        $currentDiscussionGroup = $discussionGroups->filter(function($item) use ($discussionGroupSlug) {
            return $item->slug == $discussionGroupSlug;
        })->first();

        $routeParameters = $args;
        $routePrefix  = $this->routePrefix;

        return view('pages.clients.discussions.index', compact('currentDiscussionGroup', 'discussionGroups', 'routePrefix', 'routeParameters'));
    }
}
