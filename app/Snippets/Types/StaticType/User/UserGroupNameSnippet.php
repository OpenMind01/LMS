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

class UserGroupNameSnippet extends Snippet implements SnippetInterface
{

    public $instance;
    public $class = User::class;
    public $shortCode = 'user.usergroup';
    public $description = 'Current User\'s User Group Name';
    public $requiredKeys = [];

    public function getValue()
    {
        if ($this->instance->usergroup) {
            return $this->instance->usergroup->title;
        }
        return 'No User Group';
    }
}