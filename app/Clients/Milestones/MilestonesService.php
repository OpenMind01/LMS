<?php

namespace Pi\Clients\Milestones;

use Carbon\Carbon;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Usergroups\ClientUsergroupsService;
use Pi\Events\Milestones\MilestoneCreated;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Exceptions\Milestones\InvalidAssignableType;
use Pi\Http\Requests\Milestones\MilestoneCreateRequest;
use Pi\Http\Requests\Milestones\MilestoneUpdateRequest;

class MilestonesService
{
    /**
     * @var ClientUsergroupsService
     */
    private $clientUsergroupsService;

    public function __construct(ClientUsergroupsService $clientUsergroupsService)
    {
        $this->clientUsergroupsService = $clientUsergroupsService;
    }

    /**
     * @param Client $client
     * @param int $id
     * @return Milestone
     * @throws EntityNotFoundException
     */
    public function get(Client $client, $id)
    {
        /**
         * @var Milestone $usergroup
         */
        $usergroup = Milestone::findOrFail($id);

        if($usergroup->client_id != $client->id)
        {
            throw new EntityNotFoundException(self::class, 'id in client', $id . ' ' . $client->id);
        }

        return $usergroup;
    }

    /**
     * @param User $user
     * @param Carbon $start
     * @param Carbon $end
     * @return \Illuminate\Database\Eloquent\Collection|Milestone[]
     */
    public function getUserMilestones(User $user, Carbon $start, Carbon $end)
    {
        return $user->milestones()
            ->where('finish_at', '<=', $end)
            ->where('finish_at', '>=', $start)
            ->get();
    }

    /**
     * @param Client $client
     * @return Milestone[]
     */
    public function getClientMilestones(Client $client)
    {
        return $client->milestones()->orderBy('finish_at')->get();
    }

    /**
     * @param Client $client
     * @param MilestoneCreateRequest $request
     * @return Milestone
     * @throws InvalidAssignableType
     * @throws \Pi\Exceptions\EntityNotFoundException
     */
    public function create(Client $client, MilestoneCreateRequest $request)
    {
        $milestone = new Milestone();
        $milestone->client_id = $client->id;
        $milestone->title = $request->getTitle();
        $milestone->finish_at = $request->getFinishDate();

        $assignableType = $request->getAssignableType();
        switch($assignableType)
        {
            case Milestone::ASSIGNABLE_TYPE_CLIENT:
                $milestone->assignable_type = $assignableType;
                break;
            case Milestone::ASSIGNABLE_TYPE_USERGROUP:
                $clientUsergroup = $this->clientUsergroupsService->get($client, $request->getUsergroupId());

                $milestone->assignable_type = $assignableType;
                $milestone->assignable_id = $clientUsergroup->id;
                break;
            default:
                throw new InvalidAssignableType();
        }

        $milestone->save();

        $this->syncMilestoneUsers($milestone);

        \Event::fire(new MilestoneCreated($milestone));

        return $milestone;
    }

    public function update(Milestone $milestone, MilestoneUpdateRequest $request)
    {
        $milestone->title = $request->getTitle();
        $milestone->finish_at = $request->getFinishDate();

        $milestone->save();
    }

    public function delete(Milestone $milestone)
    {
        $milestone->users()->detach();
        $milestone->delete();
    }

    /**
     * @param Milestone $milestone
     * @throws \Pi\Exceptions\Milestones\InvalidAssignableType
     */
    public function syncMilestoneUsers(Milestone $milestone)
    {
        $users = $this->getAssignedUsers($milestone);

        $milestone->users()->sync($users);
    }

    /**
     * @param Milestone $milestone
     * @return \Illuminate\Database\Eloquent\Collection|\Pi\Auth\User[]
     * @throws InvalidAssignableType
     * @throws \Pi\Exceptions\EntityNotFoundException
     */
    public function getAssignedUsers(Milestone $milestone)
    {
        switch($milestone->assignable_type)
        {
            case Milestone::ASSIGNABLE_TYPE_CLIENT:
                return $milestone->client->users;
            case Milestone::ASSIGNABLE_TYPE_USERGROUP:
                return $this->clientUsergroupsService->get($milestone->client, $milestone->assignable_id)->users;
            default:
                throw new InvalidAssignableType();
        }
    }
}