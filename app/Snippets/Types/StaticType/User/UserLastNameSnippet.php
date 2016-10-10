<?php
/**
 * Created by Justin McCombs.
 * Date: 10/7/15
 * Time: 11:28 AM
 */

namespace Pi\Snippets\Types\StaticType\User;


use Pi\Auth\User;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Snippets\Types\Snippet;

class UserLastNameSnippet extends Snippet implements SnippetInterface
{

    public $instance;
    public $class = User::class;
    public $shortCode = 'user.last_name';
    public $description = 'User Last Name';
    public $requiredKeys = [];

    public function getValue()
    {
        return $this->instance->last_name;
    }
}