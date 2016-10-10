<?php

namespace Pi\Http\Controllers\Client\DiscussionGroups\Repositories;

use Pi\Clients\Client;

class ClientRepository extends DiscussionGroupsRepository
{

    public function model()
    {
        return $this->app->make(Client::class);
    }

    public function getDiscussions()
    {
        $args = func_get_args();

        if (count($args) < 1) {
            // @TODO Throw a proper exception class
            throw new \Exception('Invalid parameter count');
        }

        list($clientSlug) = $args;

        $client = $this->getClientBySlug($clientSlug);

        return $client->discussionGroups()->with('threads')->get();
    }

    /**
     * @return \Pi\DiscussionGroups\DiscussionGroup
     * @throws \Exception
     *
     * @TODO: Refactor this method, it looks similar than the CourseRepository's one
     */
    public function getDiscussion()
    {
        $args = func_get_args();

        if (count($args) < 2) {
            // @TODO Throw a proper exception class
            throw new \Exception('Invalid parameter count');
        }

        list($clientSlug, $discussionGroupSlug) = $args;

        $client = $this->getClientBySlug($clientSlug);

        if (!$client) {
            return null;
        }

        return $client->discussionGroups()->with('threads')->whereSlug($discussionGroupSlug)->first();
    }

    /**
     * @param $slug
     * @return mixed
     * @TODO: Ensure that loading a client is done just by their owner user
     */
    public function getClientBySlug($slug)
    {
        return $this->model()->whereSlug($slug)->first();
    }

    /**
     * Alias of getClientBySlug
     *
     * @param $clientSlug
     * @return mixed
     */
    public function getDiscussionable($clientSlug)
    {
        return $this->getClientBySlug($clientSlug);
    }

    /**
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function getDiscussionableFromArgs($args)
    {
        if (!isset($args['clientSlug'])) {
            throw new \Exception('Invalid parameters');
        }

        return $this->getClientBySlug($args['clientSlug']);
    }
}
