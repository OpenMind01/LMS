<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Pi\Auth\Permission;
use Pi\Auth\UsersService;
use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\ClientCreateRequest;
use Pi\Http\Requests\Clients\ClientUpdateRequest;
use Pi\Http\Requests\Clients\ClientUsergroupsUpdateRequest;
use Pi\Domain\Industries\IndustriesService;
use Pi\Usergroups\UsergroupsService;

class ClientsController extends Controller
{
    /**
     * @var ClientsService
     */
    private $service;

    /**
     * @param ClientsService $service
     */
    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize(Permission::CLIENTS_MANAGE);

        $clients = Client::with('users')->get();
        return view('pages.admin.clients.index', compact('clients'));
    }

    public function create(UsersService $usersService)
    {
        $this->authorize(Permission::CLIENTS_MANAGE);

        $administrators = $usersService->queryAdministrators()->get()->lists('fullName', 'id');

        if(count($administrators) == 0)
        {
            return redirect()->route('admin.client.index')->with('message', ['error', 'There is no available administrators with google authentication.']);
        }

        return view('pages.admin.clients.create', [
            'administrators' => $administrators,
        ]);
    }

    public function store(ClientCreateRequest $request)
    {
        $this->authorize(Permission::CLIENTS_MANAGE);

        $client = $this->service->create($request);

        return redirect()->route('admin.clients.index')->with('message', ['success', 'Successfully created a new client: '. $client->name.'.']);
    }

    public function edit($id, IndustriesService $industriesService, UsersService $usersService)
    {
        $client = $this->service->get($id);

        $this->authorize('manage', $client);

        return view('pages.admin.clients.edit', [
            'client' => $client,
            'industriesList' => $industriesService->queryOpen()->get(),
            'currentIndustries' => $client->industries->getDictionary(),
            'administrators' => $usersService->queryAdministrators()->get()->lists('fullName', 'id'),
        ]);
    }

    /**
     * Updates a Client
     * @param ClientUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        $client = $this->service->get($id);

        $this->authorize('manage', $client);

        $this->service->update($client, $request);

        return redirect()->route('admin.clients.index')->with('message', ['success', 'Successfully updated the client '.$client->name.'.']);
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $this->authorize('manage', $client);
        if ( ! $client )
            return redirect()->back()->with('message', ['danger', 'Could not find the client.']);
        $client->delete();
        return redirect()->route('admin.clients.index')->with('message', ['warning', 'Client was removed.']);
    }
}