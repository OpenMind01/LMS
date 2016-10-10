<?php
/**
 * Created by Justin McCombs.
 * Date: 1/5/16
 * Time: 6:31 PM
 */

namespace Pi\Clients\Widgets\Roles\Student;


use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Services\UserProgressService;

class StudentCourseOverview extends BaseWidget
{

    protected $title = 'Course Overview';
    protected $description = 'Overview for a single course';
    protected $key = 'student-course-overview';
    protected $requiredKeys = [
        'course' => Course::class,
    ];
    /**
     * @var
     */
    private $userProgressService;

    public function __construct(UserProgressService $userProgressService)
    {
        $this->userProgressService = $userProgressService;
    }

    public function getData()
    {

    }

}