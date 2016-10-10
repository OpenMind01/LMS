<?php

namespace Pi\Snippets\Types\StaticType\User\Building\Room;

use Pi\Auth\User;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Types\Snippet;

class EmergencyRouteSnippet extends Snippet implements SnippetInterface
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var User
     */
    public $instance;

    public $class = User::class;
    public $shortCode = 'user.emg_route';
    public $description = 'The emergency route for user.';
    public $requiredKeys = [];


    /**
     * Returns the value to be used in the snippet
     * @return mixed
     */
    public function getValue()
    {
        if ($this->instance->room && $this->instance->room->hasEmergencyRoute())
        {
            return '<img src="' . $this->instance->room->getEmergencyRoute()->url() . '"/>';
        }

        if($this->instance->client && $this->instance->client->hasEmergencyRoute())
        {
            return '<img src="' . $this->instance->client->getEmergencyRoute()->url() . '"/>';
        }

        return '';
    }

    /**
     * Returns whether or not the snippet should be escaped
     * @return bool
     */
    public function shouldEscapeValue()
    {
        return false;
    }
}