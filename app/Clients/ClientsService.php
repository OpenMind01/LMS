<?php

namespace Pi\Clients;

use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Auth\UsersService;
use Pi\Clients\Theme\ThemesService;
use Pi\Clients\Usergroups\ClientUsergroupsService;
use Pi\Exceptions\Clients\EmptyUsergroupsException;
use Pi\Exceptions\Clients\ExistingSlugException;
use Pi\Exceptions\Clients\InvalidAdministrator;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Exceptions\Clients\EmptyIndustriesException;
use Pi\Helpers\SlugHelper;
use Pi\Http\Requests\Clients\Activation\MainRequest;
use Pi\Http\Requests\Clients\Activation\IndustriesRequest;
use Pi\Http\Requests\Clients\Activation\UsergroupsRequest;
use Pi\Http\Requests\Clients\ClientCreateRequest;
use Pi\Http\Requests\Clients\ClientUpdateRequest;
use Pi\Http\Requests\Clients\ClientUsergroupsUpdateRequest;

class ClientsService
{
    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * @var ClientUsergroupsService
     */
    private $clientUsergroupsService;
    /**
     * @var ThemesService
     */
    private $themesService;

    public function __construct(UsersService $usersService, ClientUsergroupsService $clientUsergroupsService, ThemesService $themesService)
    {
        $this->usersService = $usersService;
        $this->clientUsergroupsService = $clientUsergroupsService;
        $this->themesService = $themesService;
    }

    /**
     * @param $id
     * @return Client
     */
    public function get($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * @param ClientCreateRequest $request
     * @return Client
     * @throws ExistingSlugException
     * @throws \Pi\Exceptions\Users\ExistingEmailException
     * @throws \Pi\Exceptions\Users\InvalidRoleException
     */
    public function create(ClientCreateRequest $request)
    {
        $administrator = $this->usersService->get($request->getAdministratorId());
        if(!$administrator->isAdmin())
        {
            return new InvalidAdministrator($administrator);
        }

        /*if(!$administrator->hasGoogleToken())
        {
            return new InvalidAdministrator($administrator);
        }*/

        $client = new Client();
        $client->name = $request->getName();
        $client->slug = SlugHelper::generate($client->name, Client::all()->lists('slug')->toArray());
        $client->administrator_id = $administrator->id;

        // Check if owner can be created. It's better to do it before creating a client. Client without owner is useless.
        $this->usersService->checkBeforeCreate($request->getOwnersEmail(), $client, Role::MODERATOR);

        $theme = $this->themesService->create();
        $client->theme_id = $theme->id;

        $client->save();

        $ownerUser = $this->usersService->create($request->getOwnersEmail(), $client, Role::MODERATOR);

        $client->owner_id = $ownerUser->id;

        $client->save();

        return $client;
    }

    /**
     * @param Client $client
     * @param ClientUpdateRequest $request
     * @return Client
     */
    public function update(Client $client, ClientUpdateRequest $request)
    {
        $administrator = $this->usersService->get($request->getAdministratorId());
        if(!$administrator->isAdmin())
        {
            return new InvalidAdministrator($administrator);
        }

        $client->name = $request->getName();
        $client->slug = $request->getSlug();
        $client->administrator_id = $administrator->id;

        $client->industries()->sync($request->getIndustries());

        $client->save();
    }

    /**
     * @param Client $client
     * @param ClientUsergroupsUpdateRequest $request
     * @return Client
     */
    public function updateUsergroups(Client $client, ClientUsergroupsUpdateRequest $request)
    {
        $client->usergroups()->sync($request->getUsergroups());

        $client->save();
    }

    /**
     * @param $clientSlug
     * @return Client
     * @throws EntityNotFoundException
     */
    public function getClientBySlug($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();

        if(!$client) throw new EntityNotFoundException('client', 'slug', $clientSlug);

        return $client;
    }

    /**
     * @param User $user
     * @return Client[]
     */
    public function getClientsAllowedToModerate(User $user)
    {
        if($user->isSuperAdmin() || $user->isAdmin())
        {
            return Client::all();
        }

        if($user->isModerator())
        {
            return [$user->client];
        }

        return [];
    }
}