<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Client\Management\Usergroups;

use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Clients\Usergroups\ClientUsergroupsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Usergroups\UsersInviteRequest;
use Pi\Usergroups\UsergroupsService;

class UsergroupUsersController extends Controller
{
    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * @var ClientUsergroupsService
     */
    private $clientUsergroupsService;

    public function __construct(ClientUsergroupsService $clientUsergroupsService, ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
        $this->clientUsergroupsService = $clientUsergroupsService;
    }

    public function index($clientSlug, $clientUsergroupId)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $clientUsergroup = $this->clientUsergroupsService->get($client, $clientUsergroupId);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, $clientUsergroup->usergroup->title . ' user group users');

        return view('pages.clients.manage.usergroups.users.index', compact('client', 'clientUsergroup'));
    }

    public function create($clientSlug, $clientUsergroupId)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $clientUsergroup = $this->clientUsergroupsService->get($client, $clientUsergroupId);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, $clientUsergroup->usergroup->title . ' user group users: invite');

        return view('pages.clients.manage.usergroups.users.create', compact('client', 'clientUsergroup'));
    }

    public function store($clientSlug, $clientUsergroupId, UsersInviteRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $clientUsergroup = $this->clientUsergroupsService->get($client, $clientUsergroupId);

        $this->authorize('manage', $client);

        $this->clientUsergroupsService->inviteUsers($clientUsergroup, $request);

        return redirect()->route('clients.manage.usergroups.users.index', [$client->slug, $clientUsergroup->id])->with('message', ['success', 'Users invited']);
    }

/*    public function edit($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $resource = Resource::whereId($id)->with('dismissedUsers')->first();
        $this->authorize('manage', [$resource, $client]);
        if ( ! $resource )
            return redirect()->back()->with('message', ['danger', 'Could not find the resource.']);

        return view('pages.clients.manage.usergroups.edit', compact('resource', 'client'));
    }

    public function update(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $resource = Resource::find($id);
        $this->authorize('manage', [$resource, $client]);
        if ( ! $resource )
            return redirect()->back()->with('message', ['danger', 'Could not find the resource.']);

        $this->validate($request, Resource::rules($resource));

        $resource->update($request->all());

        $this->resourcesRepository->clearCacheForClient($client);

        return redirect()->route('clients.manage.usergroups.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the resource '.$resource->name.'.']);
    }

    public function destroy($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $resource = Resource::find($id);
        $this->authorize('manage', [$resource, $client]);
        if ( ! $resource )
            return redirect()->back()->with('message', ['danger', 'Could not find the resource.']);
        $resource->delete();
        $this->resourcesRepository->clearCacheForClient($client);
        return redirect()->back()->with('message', ['warning', 'Resource was removed.']);
    }
*/

    private function addBreadcrumbs(Client $client, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->add(route('clients.manage.usergroups.index', $client->slug), 'User groups');
        $this->breadcrumbsHelper->addTitle($title);
    }
}