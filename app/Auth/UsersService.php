<?php

namespace Pi\Auth;

use Pi\Clients\Client;
use Pi\Events\Users\UserCreated;
use Pi\Exceptions\Users\ExistingEmailException;
use Pi\Exceptions\Users\InvalidRoleException;
use Pi\Http\Requests\Users\UserActivationRequest;

class UsersService
{
    /**
     * @param $email
     * @param Client $client
     * @param $role
     * @throws ExistingEmailException
     * @throws InvalidRoleException
     */
    public function checkBeforeCreate($email, Client $client, $role)
    {
        if(!in_array($role, [Role::STUDENT, Role::MODERATOR, Role::ADMIN]))
        {
            throw new InvalidRoleException();
        }

        if(User::whereEmail($email)->exists())
        {
            throw new ExistingEmailException($email);
        }
    }

    /**
     * @param $id
     * @return User
     */
    public function get($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param $email
     * @param Client $client
     * @param $role
     * @return User
     * @throws ExistingEmailException
     * @throws InvalidRoleException
     */
    public function create($email, Client $client, $role)
    {
        $this->checkBeforeCreate($email, $client, $role);

        $password = str_random(8);

        $user = new User();
        $user->email = $email;
        $user->client_id = $client->id;
        $user->active = false;
        $user->password = bcrypt($password);
        $user->role = $role;

        $user->save();

        \Event::fire(new UserCreated($user, $password));

        return $user;
    }

    public function activate(User $user, UserActivationRequest $request)
    {
        //@todo some checks here?

        $user->first_name = $request->getFirstName();
        $user->last_name = $request->getLastName();

        $user->phone_mobile = $request->getMobilePhone();
        $user->phone_work = $request->getWorkPhone();
        $user->phone_home = $request->getHomePhone();

        $user->setAddress($request->getAddress());

        $user->active = 1;

        $user->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static
     */
    public function queryAdministrators()
    {
        return User::whereRole(Role::ADMIN)->orWhere('role', Role::SUPER_ADMIN);

        /*return User::whereNotNull('google_token')
            ->where('role', Role::ADMIN)
            ->orWhere('role', Role::SUPER_ADMIN);*/
    }
}