<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/18/15
 * Time: 10:46 AM
 */

namespace Pi\Http\Controllers\Client\DiscussionGroups\Repositories;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\CourseRepository as CourseRepo;

class ModuleDiscussionGroupRepository extends DiscussionGroupsRepository
{
    /**
     * @var CourseRepo
     */
    protected $courseRepo;

    public function __construct(CourseRepo $courseRepo)
    {
        $this->courseRepo = $courseRepo;
        parent::__construct();
    }

    public function getDiscussions()
    {
        $args = func_get_args();

        if (count($args) < 3) {
            // @TODO Throw a proper exception class
            throw new \Exception('Invalid parameter count');
        }

        list($clientSlug, $courseSlug, $moduleSlug) = $args;

        $module = $this->getModuleBySlug($clientSlug, $courseSlug, $moduleSlug);

        if (!$module) {
            return null;
        }

        return $module->discussionGroups()->with('threads')->get();
    }

    public function getModuleBySlug($clientSlug, $courseSlug, $moduleSlug)
    {
        $course = $this->courseRepo->getCourseBySlug($clientSlug, $courseSlug);
        $module = $course->modules()->whereSlug($moduleSlug)->first();

        return $module;
    }

    /**
     * Alias of getModuleBySlug
     *
     * @param $clientSlug
     * @param $courseSlug
     * @param $moduleSlug
     * @return mixed
     */
    public function getDiscussionable($clientSlug, $courseSlug, $moduleSlug)
    {
        return $this->getModuleBySlug($clientSlug, $courseSlug, $moduleSlug);
    }

    /**
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function getDiscussionableFromArgs($args)
    {
        if (!isset($args['clientSlug']) || !isset($args['courseSlug']) || !isset($args['moduleSlug'])) {
            throw new \Exception('Invalid parameters');
        }

        return $this->getModuleBySlug($args['clientSlug'], $args['courseSlug'], $args['moduleSlug']);
    }
}
