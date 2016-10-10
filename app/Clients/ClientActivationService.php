<?php

namespace Pi\Clients;

use Pi\Clients\Usergroups\ClientUsergroupCreator;
use Pi\Exceptions\Clients\EmptyIndustriesException;
use Pi\Exceptions\Clients\EmptyUsergroupsException;
use Pi\Http\Requests\Clients\Activation\IndustriesRequest;
use Pi\Http\Requests\Clients\Activation\MainRequest;
use Pi\Http\Requests\Clients\Activation\UsergroupsRequest;

class ClientActivationService
{
    /**
     * @var ClientUsergroupCreator
     */
    private $clientUserGroupCreator;

    public function __construct(ClientUsergroupCreator $clientUserGroupCreator)
    {
        $this->clientUserGroupCreator = $clientUserGroupCreator;
    }

    public function activateMain(Client $client, MainRequest $request)
    {
        $client->name = $request->getName();
        $client->description = $request->getDescription();

        $this->updateActive($client);

        $client->save();
    }

    public function activateIndustries(Client $client, IndustriesRequest $request)
    {
        $industries = $request->getIndustries();

        if(count($industries) == 0)
            throw new EmptyIndustriesException();

        $client->industries()->sync($industries);

        if($client->industries->count() == 0)
            throw new EmptyIndustriesException();

        $this->updateActive($client);

        $client->save();
    }

    public function activateUsergroups(Client $client, UsergroupsRequest $request)
    {
        $usergroups = $request->getUsergroups();

        if(count($usergroups) == 0)
            throw new EmptyUsergroupsException();

        foreach($usergroups as $usergroupId)
        {
            $this->clientUserGroupCreator->create($client, $usergroupId);
        }

        if($client->usergroups()->count() == 0)
            throw new EmptyUsergroupsException();

        $this->updateActive($client);

        $client->save();
    }

    private function updateActive(Client $client)
    {
        if(!empty($client->name) && $client->industries()->count() > 0 && $client->usergroups()->count() > 0)
            $client->active = true;
    }
}