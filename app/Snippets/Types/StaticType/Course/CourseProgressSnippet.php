<?php

namespace Pi\Snippets\Types\StaticType\Course;
use Pi\Auth\User;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Services\UserProgressService;
use Pi\Snippets\Types\Snippet;
class CourseProgressSnippet extends Snippet
{

    public $instance;
    public $class = Course::class;
    public $shortCode = 'course.progress';
    public $description = 'Current user progress';
    public $requiredKeys = ['user' => User::class];

    /**
     * @var UserProgressService
     */
    private $userProgressService;

    public function __construct(UserProgressService $userProgressService)
    {
        $this->userProgressService = $userProgressService;
    }


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        if ($this->user && $this->instance)
        {
            if ($course = $this->user->courses->where('id', $this->instance->id)->first()) {
                return $course->pivot->progress_percent.'%';
            }
        }
        return '0%';
    }
}