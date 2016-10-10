<?php
/**
 * Created by Justin McCombs.
 * Date: 9/30/15
 * Time: 4:53 PM
 */

namespace Pi\Http\Controllers\Client\Management;

use Pi\Clients\Resources\Resource;
use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Http\Controllers\Controller;
use Pi\Clients\Resources\ResourcesRepository;

class ClientResourceController extends Controller
{

    /**
     * @var ResourcesRepository
     */
    private $resourcesRepository;

    public function __construct(ResourcesRepository $resourcesRepository)
    {
        $this->resourcesRepository = $resourcesRepository;
    }

    public function index($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Resource), $client]);
        $resources = Resource::whereClientId($client->id)->get();
        return view('pages.clients.manage.resources.index', compact('resources', 'client'));
    }

    public function create($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Resource), $client]);
        return view('pages.clients.manage.resources.create', compact('client'));
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Resource), $client]);
        $this->validate($request, Resource::rules());
        $resource = Resource::create($request->all());
        $client->resources()->save($resource);

        return redirect()->route('clients.manage.resources.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new resource: '. $resource->name.'.']);
    }

    public function edit($clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $resource = Resource::whereId($id)->first();
        $this->authorize('manage', [$resource, $client]);
        if ( ! $resource )
            return redirect()->back()->with('message', ['danger', 'Could not find the resource.']);

        return view('pages.clients.manage.resources.edit', compact('resource', 'client'));
    }

    /**
     * Updates a Resource
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()
            ->route('clients.manage.resources.index', ['clientSlug' => $clientSlug])
            ->with('message', ['success', 'Successfully updated the resource '.$resource->name.'.']);
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
        return redirect()->back()->with('message', ['warning', 'Resource was removed.']);
    }

}