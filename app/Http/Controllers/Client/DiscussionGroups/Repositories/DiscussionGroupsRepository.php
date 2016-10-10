<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/11/15
 * Time: 4:26 PM
 */

namespace Pi\Http\Controllers\Client\DiscussionGroups\Repositories;
use Pi\DiscussionGroups\DiscussionGroup;
use Illuminate\Http\Request;
use Pi\Helpers\SlugHelper;
use Pi\DiscussionGroups\DiscussionGroupPost as Post;

abstract class DiscussionGroupsRepository
{
    protected $app;

    abstract function getDiscussions();

    public function __construct()
    {
        $this->app = app();
    }

    /**
     * @param DiscussionGroup $discussionGroup
     * @param Request $request
     * @return \Pi\DiscussionGroups\DiscussionGroupPost
     */
    public function addThreadFromRequest(DiscussionGroup $discussionGroup, Request $request)
    {
        \DB::beginTransaction();

        /**
         * @var $thread \Pi\DiscussionGroups\DiscussionGroupThread
         */
        $thread = $discussionGroup->threads()->create([
            'title' => $request->input('title'),
            'slug' => SlugHelper::generate($request->input('title'), $discussionGroup->threads()->lists('slug')->toArray()),
            'user_id' => \Auth::user()->id,
            'client_id' => $discussionGroup->client_id
        ]);

        /**
         * @var $post \Pi\DiscussionGroups\DiscussionGroupPost
         */
        $post = $thread->posts()->create([
            'user_id' => \Auth::user()->id,
            'body' => $request->input('body'),
            'type' => Post::TYPE_QUESTION,
            'client_id' => $discussionGroup->client_id
        ]);

        \DB::commit();

        return $post;
    }
}
