<?php

namespace Pi\Snippets\Types\StaticType\Course\Module;

use Pi\Clients\Courses\Module;
use Pi\Snippets\Types\Snippet;

class ModuleNumberSnippet extends Snippet
{

    public $instance;
    public $class = Module::class;
    public $shortCode = 'course.module.number';
    public $description = 'Number of the current module';
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