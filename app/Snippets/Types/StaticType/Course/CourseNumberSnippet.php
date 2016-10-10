<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 3:00 PM
 */

namespace Pi\Snippets\Types\StaticType\Course;


use Pi\Clients\Courses\Course;
use Pi\Snippets\Types\Snippet;

class CourseNumberSnippet extends Snippet
{

    public $instance;
    public $class = Course::class;
    public $shortCode = 'course.number';
    public $description = 'The number of the current course.';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        return $this->instance->number;
    }
}