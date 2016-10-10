<?php

namespace Pi\Snippets\Types\StaticType\Course\Module;

use Pi\Clients\Courses\Module;
use Pi\Snippets\Types\Snippet;

class ModuleNameSnippet extends Snippet
{

    public $instance;
    public $class = Module::class;
    public $shortCode = 'course.module.name';
    public $description = 'Name of the current module';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        return $this->instance->name;
    }
}