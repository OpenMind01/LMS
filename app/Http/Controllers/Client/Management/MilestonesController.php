<?php

namespace Pi\Http\Controllers\Client\Management;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Pi\Auth\Permission;
use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Clients\Milestones\MilestonesService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Milestones\MilestoneCreateRequest;
use Pi\Http\Requests\Milestones\MilestoneUpdateRequest;
use Redirect;

class MilestonesController extends Controller
{
    /**
     * @var MilestonesService
     */
    private $service;

    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * MilestonesController constructor.
     * @param MilestonesService $service
     * @param ClientsService $clientsService
     */
    public function __construct(MilestonesService $service, ClientsService $clientsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
    }

    public function index($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $this->addBreadcrumbs($client);

        return view('pages.clients.manage.milestones.index', [
            'client' => $client,
            'milestones' => $this->service->getClientMilestones($client),
        ]);
    }

    public function create($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $usergroups = [];
        foreach($client->innerUsergroups()->with('usergroup')->get() as $clientUsergroup)
        {
            $usergroups[$clientUsergroup->id] = $clientUsergroup->usergroup->title;
        }

        $this->addBreadcrumbs($client, 'Create milestone');

        return view('pages.clients.manage.milestones.create', [
            'client' => $client,
            'usergroups' => $usergroups,
        ]);
    }

    public function store($clientSlug, MilestoneCreateRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $this->service->create($client, $request);

        return redirect()->route('clients.manage.milestones.index', $client->slug)->with('message', ['success', 'Milestone created']);
    }

    public function edit($clientSlug, $id)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $milestone = $this->service->get($client, $id);

        $this->addBreadcrumbs($client, 'Edit milestone');

        return view('pages.clients.manage.milestones.edit', [
            'client' => $client,
            'milestone' => $milestone,
        ]);
    }

    public function update($clientSlug, $id, MilestoneUpdateRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $milestone = $this->service->get($client, $id);

        $this->service->update($milestone, $request);

        return redirect()->route('clients.manage.milestones.index', $client->slug)->with('message', ['success', 'Milestone updated']);
    }

    public function destroy($clientSlug, $id)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageMilestones', $client);

        $milestone = $this->service->get($client, $id);

        $this->service->delete($milestone);

        return redirect()->route('clients.manage.milestones.index', $client->slug)->with('message', ['success', 'Milestone deleted']);
    }

    private function addBreadcrumbs(Client $client, $title = null)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->add(route('clients.manage.milestones.index', $client->slug), 'Milestones');

        if($title != null)
        {
            $this->breadcrumbsHelper->addTitle($title);
        }
    }
}