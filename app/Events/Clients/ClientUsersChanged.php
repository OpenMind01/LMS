<?php

namespace Pi\Events\Clients;

use Illuminate\Queue\SerializesModels;
use Pi\Clients\Client;
use Pi\Events\Event;

class ClientUsersChanged extends Event
{
    use SerializesModels;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}