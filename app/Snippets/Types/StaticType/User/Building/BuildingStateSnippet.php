<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 2:28 PM
 */

namespace Pi\Snippets\Types\StaticType\User\Building;


use Pi\Auth\User;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Types\Snippet;

class BuildingStateSnippet extends Snippet implements SnippetInterface
{

    /**
     * @var User
     */
    public $user;

    public $instance;
    public $class = User::class;
    public $shortCode = 'user.building.state';
    public $description = 'The state of the user\'s building.';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        if ($this->instance->room && $this->instance->room->building)
            return $this->instance->room->building->state;

        return 'Not Assigned';
    }

}