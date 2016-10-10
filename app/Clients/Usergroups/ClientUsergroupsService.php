<?php

namespace Pi\Clients\Usergroups;

use Illuminate\Contracts\Auth\Guard;
use Pi\Auth\Role;
use Pi\Auth\UsersService;
use Pi\Clients\Client;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Clients\Courses\Module;
use Pi\Events\Clients\ClientUsersChanged;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Exceptions\Usergroups\ArticleOfUnusedModuleUsedException;
use Pi\Exceptions\Usergroups\InvalidArticleException;
use Pi\Exceptions\Usergroups\InvalidModuleException;
use Pi\Exceptions\Usergroups\UsergroupCannotBeReadyException;
use Pi\Exceptions\NotAllowedException;
use Pi\Http\Requests\Clients\Usergroups\UsersInviteRequest;
use Pi\Http\Requests\Usergroups\UsergroupCreateRequest;
use Pi\Http\Requests\Usergroups\UsergroupUpdateRequest;
use Pi\Domain\Industries\Industry;
use Pi\Usergroups\UsergroupsService;

class ClientUsergroupsService
{
    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * @var UsergroupsService
     */
    private $usergroupsService;

    public function __construct(UsersService $usersService, UsergroupsService $usergroupsService)
    {
        $this->usersService = $usersService;
        $this->usergroupsService = $usergroupsService;
    }

    /**
     * @param Client $client
     * @param int $id
     * @return ClientUsergroup
     * @throws EntityNotFoundException
     */
    public function get(Client $client, $id)
    {
        /**
         * @var ClientUsergroup $usergroup
         */
        $usergroup = ClientUsergroup::findOrFail($id);

        if($usergroup->client_id != $client->id)
        {
            throw new EntityNotFoundException(self::class, 'id in client', $id . ' ' . $client->id);
        }

        return $usergroup;
    }

    /**
     * @param Client $client
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Client $client)
    {
        return $client->usergroups()->orderBy('title');
    }

    public function inviteUsers(ClientUsergroup $clientUsergroup, UsersInviteRequest $request)
    {
        $emails = $request->getEmails();

        foreach($emails as $email)
        {
            $this->usersService->checkBeforeCreate($email, $clientUsergroup->client, Role::STUDENT);
        }

        foreach($emails as $email)
        {
            $user = $this->usersService->create($email, $clientUsergroup->client, Role::STUDENT);

            $user->client_usergroup_id = $clientUsergroup->id;
            $user->save();
        }

        \Event::fire(new ClientUsersChanged($clientUsergroup->client));
    }
}