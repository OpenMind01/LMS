<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/11/15
 * Time: 5:37 PM
 */

namespace Pi\Http\Controllers\Client\DiscussionGroups\Repositories;

use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ClientRepository as ClientRepo;

/**
 * Class CourseRepository
 * @package Pi\Http\Controllers\Client\DiscussionGroups
 *
 * @method: getDiscussionableElementFromRoute()
 */
class CourseRepository extends DiscussionGroupsRepository
{
    /**
     * @var ClientRepo
     */
    protected $clientRepo;

    public function __construct(ClientRepo $clientRepo)
    {
        $this->clientRepo = $clientRepo;
        parent::__construct();
    }

    public function getDiscussions()
    {
        $args = func_get_args();

        if (count($args) < 2) {
            // @TODO Throw a proper exception class
            throw new \Exception('Invalid parameter count');
        }

        list($clientSlug, $courseSlug) = $args;

        $course = $this->getCourseBySlug($clientSlug, $courseSlug);

        if (!$course) {
            return null;
        }

        return $course->discussionGroups()->with('threads')->get();
    }

    public function getDiscussion()
    {
        $args = func_get_args();

        if (count($args) < 3) {
            // @TODO Throw a proper exception class
            throw new \Exception('Invalid parameter count');
        }

        list($clientSlug, $courseSlug, $discussionGroupSlug) = $args;

        $course = $this->getCourseBySlug($clientSlug, $courseSlug);

        if (!$course) {
            return null;
        }

        return $course->discussionGroups()->with('threads')->whereSlug($discussionGroupSlug)->get();
    }

    /**
     * @param $clientSlug
     * @param $courseSlug
     * @return mixed
     */
    public function getCourseBySlug($clientSlug, $courseSlug)
    {
        $client = $this->clientRepo->getClientBySlug($clientSlug);
        $course = $client->courses()->whereSlug($courseSlug)->first();

        return $course;
    }

    /**
     * Alias of getCourseBySlug
     *
     * @param $clientSlug
     * @param $courseSlug
     * @return mixed
     */
    public function getDiscussionable($clientSlug, $courseSlug)
    {
        return $this->getCourseBySlug($clientSlug, $courseSlug);
    }

    /**
     * Loads a course using an array of params
     *
     * @param array $args
     * @return mixed|null
     * @throws \Exception
     */
    public function getDiscussionableFromArgs($args = [])
    {
        if (!isset($args['clientSlug']) || !isset($args['courseSlug'])) {
            throw new \Exception('Invalid parameters');
        }

        return $this->getCourseBySlug($args['clientSlug'], $args['courseSlug']);
    }
}
