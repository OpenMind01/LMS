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
use Pi\Domain\Industries\IndustriesService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Industries\UpdateClientIndustriesRequest;
use Pi\Http\Requests\Clients\Usergroups\ClientUsergroupCreateRequest;
use Pi\Usergroups\UsergroupsService;

class IndustriesController extends Controller
{
    /**
     * @var ClientsService
     */
    private $clientsService;

    private $routePrefix = 'clients.manage.industries.';

    public function __construct(ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

    public function index($clientSlug, IndustriesService $industriesService)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, 'Industries');

        return view('pages.clients.manage.industries.index', [
            'client' => $client,
            'routePrefix' => $this->routePrefix,
            'industriesList' => $industriesService->queryOpen()->get(),
            'currentIndustries' => $client->industries->getDictionary(),
        ]);
    }

    public function store($clientSlug, UpdateClientIndustriesRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $client->industries()->sync($request->getIndustries());

        return redirect()->route('clients.show', ['clientSlug' => $clientSlug])
            ->with('message', ['success', 'Industries updated.']);
    }

    private function addBreadcrumbs($client, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}