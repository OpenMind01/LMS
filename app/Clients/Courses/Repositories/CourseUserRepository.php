<?php
/**
 * Created by Justin McCombs.
 * Date: 12/29/15
 * Time: 10:08 PM
 */

namespace Pi\Clients\Courses\Repositories;


use Pi\Auth\User;
use Pi\Clients\Courses\Course;
class CourseUserRepository
{

    /**
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function userBelongsToCourse(User $user, Course $course)
    {
        return (bool) $course->users->where('id', $user->id)->count();
    }

    public function getUserCourseProgress(User $user, Course $course) {
        if ($_user = $course->users->where('id', $user->id)->first()) {
            return $_user->pivot->progress_percent;
        }
        return '-';
    }

    public function addUserToCourse(User $user, Course $course) {
        if ( ! $this->userBelongsToCourse($user, $course)) {
            $course->users()->attach($user->id);
        }
        return $this;
    }

    public function removeUserFromCourse(User $user, Course $course) {
        if ( $this->userBelongsToCourse($user, $course)) {
            $course->users()->detach($user->id);
        }
        return $this;
    }



}