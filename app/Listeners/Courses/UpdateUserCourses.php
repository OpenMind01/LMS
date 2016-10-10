<?php

namespace Pi\Listeners\Courses;

use Pi\Clients\Courses\Services\CourseUsersSyncService;
use Pi\Events\Clients\ClientUsersChanged;
use Pi\Events\Courses\CourseCreated;

class UpdateUserCourses
{
    /**
     * @var CourseUsersSyncService
     */
    private $courseUsersSyncService;

    public function __construct(CourseUsersSyncService $courseUsersSyncService)
    {
        $this->courseUsersSyncService = $courseUsersSyncService;
    }

    public function onClientUsersChanged(ClientUsersChanged $event)
    {
        $this->courseUsersSyncService->synchronizeClientCoursesAndUsers($event->getClient());
    }

    public function onCourseCreated(CourseCreated $event)
    {
        $this->courseUsersSyncService->synchronizeCourse($event->getCourse());
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            ClientUsersChanged::class,
            self::class . '@onClientUsersChanged'
        );

        $events->listen(
            CourseCreated::class,
            self::class . '@onCourseCreated'
        );
    }
}