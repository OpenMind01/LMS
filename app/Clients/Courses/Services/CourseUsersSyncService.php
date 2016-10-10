<?php

namespace Pi\Clients\Courses\Services;
use Pi\Auth\User;
use Pi\Clients\Client;

class CourseUsersSyncService
{
    /**
     * @var UserProgressService
     */
    private $userProgressService;

    public function __construct(UserProgressService $userProgressService)
    {
        $this->userProgressService = $userProgressService;
    }

    public function synchronizeClientCoursesAndUsers(Client $client)
    {
        $users = $client->users->getDictionary();

        foreach($client->courses as $course)
        {
            if($course->type == Course::TYPE_CLIENT)
            {
                $this->synchronizeCourseUsers($course, $users);
            }
        }

        foreach($client->innerUsergroups as $clientUsergroup)
        {
            $this->synchronizeCourseUsers($clientUsergroup->course, $clientUsergroup->users->getDictionary());
        }
    }

    public function synchronizeCourse(Course $course)
    {
        if($course->type == Course::TYPE_CLIENT)
        {
            $this->synchronizeCourseUsers($course, $course->client->users->getDictionary());
        }

        // usergroup courses always synchronizes by synchronizeClientCoursesAndUsers function
    }

    /**
     * @param Course $course
     * @param User[] $users
     * @throws \Pi\Exceptions\Clients\Courses\UserAlreadyAssignedException
     */
    private function synchronizeCourseUsers(Course $course, $users)
    {
        $userIds = array_keys($users);

        $courseUsers = $course->users->getDictionary();
        $courseUserIds = array_keys($courseUsers);

        $userIdsToAdd = array_diff($userIds, $courseUserIds);

        foreach ($userIdsToAdd as $userId)
        {
            $this->userProgressService->createCourseUser($course, $users[$userId]);
        }

        $userIdsToDelete = array_diff($courseUserIds, $userIds);
        foreach($userIdsToDelete as $userId)
        {
            $course->users()->detach($userId);
        }
    }


}