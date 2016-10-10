<?php
/**
 * Created by Justin McCombs.
 * Date: 10/12/15
 * Time: 11:15 AM
 */

namespace Pi\Snippets\Types\StaticType\User;


use Pi\Auth\User;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Snippets\Types\Snippet;

class UserRolesListSnippet extends Snippet implements SnippetInterface
{

    /**
     * @var User
     */
    public $user;

    public $instance;
    public $class = User::class;
    public $shortCode = 'user.roles';
    public $description = 'The role of the user.';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        return $this->user->role;
    }
}