<?php

namespace Pi\Snippets\Types\StaticType\Course;

use Pi\Clients\Courses\Course;
use Pi\Snippets\Types\Snippet;

class CourseModuleCountSnippet extends Snippet
{

    public $instance;
    public $class = Course::class;
    public $shortCode = 'course.module_count';
    public $description = 'Number of modules in the course';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        return $this->instance->modules->count();
    }
}