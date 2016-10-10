<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Client\Management\Usergroups;

use Pi\Clients\ClientsService;
use Pi\Clients\Usergroups\ClientUsergroupCreator;
use Pi\Clients\Usergroups\ClientUsergroupsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Usergroups\ClientUsergroupCreateRequest;
use Pi\Usergroups\UsergroupsService;

class UsergroupsController extends Controller
{
    /**
     * @var ClientUsergroupsService
     */
    private $service;

    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * @var UsergroupsService
     */
    private $usergroupsService;

    private $routePrefix = 'clients.manage.usergroups.';

    public function __construct(ClientUsergroupsService $service, ClientsService $clientsService, UsergroupsService $usergroupsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
        $this->usergroupsService = $usergroupsService;
    }

    public function index($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, 'User groups');

        return view('pages.clients.manage.usergroups.index', [
            'client' => $client,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function create($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, 'Create user group');

        return view('pages.clients.manage.usergroups.create', [
            'client' => $client,
            'routePrefix' => $this->routePrefix,
            'usergroups' => $this->usergroupsService->queryOpen()->whereNotIn('id', $client->innerUsergroups->lists('usergroup_id'))->get()
        ]);
    }

    public function store($clientSlug, ClientUsergroupCreateRequest $request, ClientUsergroupCreator $clientUserGroupCreator)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $clientUserGroupCreator->create($client, $request->getUsergroupId());

        return redirect()->route('clients.manage.usergroups.index', ['clientSlug' => $clientSlug])
            ->with('message', ['success', 'User group created.']);
    }
/*
    public function edit($clientSlug, $id)
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

    private function addBreadcrumbs($client, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}