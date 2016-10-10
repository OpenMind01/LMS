<?php
/**
 * Created by Justin McCombs.
 * Date: 10/7/15
 * Time: 11:28 AM
 */

namespace Pi\Snippets\Types\StaticType\Client;


use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Snippets\Types\Snippet;

class ClientNameSnippet extends Snippet implements SnippetInterface
{

    public $instance;
    public $class = Client::class;
    public $shortCode = 'client.name';
    public $description = 'Client Name';
    public $requiredKeys = [
        'user' => User::class,
    ];

    public function getValue()
    {
        return $this->instance->name;
    }


}