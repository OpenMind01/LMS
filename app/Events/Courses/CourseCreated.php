<?php

namespace Pi\Events\Courses;

use Pi\Clients\Courses\Course;
use Pi\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Event CourseCreated occurs when usual course created in client.
 * @package Pi\Events\Courses
 */
class CourseCreated extends Event
{
    use SerializesModels;

    /**
     * @var Course
     */
    private $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}
