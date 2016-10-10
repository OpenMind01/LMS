<?php
/**
 * Created by PhpStorm.
 * User: yefb
 * Date: 11/12/15
 * Time: 10:37 AM
 */

namespace Pi\Http\Controllers\Client\DiscussionGroups\Repositories;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\ClientRepository as ClientRepo;
use Pi\Http\Controllers\Client\DiscussionGroups\Repositories\CourseRepository as CourseRepo;

class ThreadRepository
{
//    protected $clientRepo;

    protected $courseRepo;

    public function __construct(ClientRepo $clientRepo, CourseRepo $courseRepo)
    {
    //        $this->clientRepo = $clientRepo;
        $this->courseRepo = $courseRepo;
    }

    public function getThreadBySlug($clientSlug, $courseSlug, $threadSlug)
    {
//        $course = $this->courseRepo->getCourseBySlug($clientSlug, $courseSlug);
    }
}
