<?php

namespace Pi\Snippets\Types\StaticType\Course\Article;

use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Module;
use Pi\Snippets\Types\Snippet;

class ArticleNumberSnippet extends Snippet
{

    public $instance;
    public $class = Article::class;
    public $shortCode = 'course.article.number';
    public $description = 'Number of the current article';
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