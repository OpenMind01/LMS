<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 2:28 PM
 */

namespace Pi\Snippets\Types\StaticType\User\Building\Room;


use Pi\Auth\User;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Types\Snippet;

class RoomNumberSnippet extends Snippet implements SnippetInterface
{
    /**
     * @var User
     */
    public $user;

    public $instance;
    public $class = User::class;
    public $shortCode = 'user.room.number';
    public $description = 'The number of the user\'s room.';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        if ($this->instance->room)
            return $this->instance->room->number;

        return 'Not Assigned';
    }
}