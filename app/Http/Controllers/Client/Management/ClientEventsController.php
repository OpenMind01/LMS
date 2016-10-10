<?php

namespace Pi\Http\Controllers\Client\Management;

use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Clients\Events\ClientEventsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Events\ClientEventCreateRequest;
use Pi\Http\Requests\Clients\Events\ClientEventUpdateRequest;

class ClientEventsController extends Controller
{
    /**
     * @var ClientEventsService
     */
    private $service;
    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(ClientEventsService $service, ClientsService $clientsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
    }

    public function index($clientSlug)
    {
        $client = $this->getClient($clientSlug);

        $this->addBreadcrumbs($client, 'Events');

        return view('pages.clients.manage.events.index', [
            'client' => $client,
            'events' => $this->service->query($client)->paginate(25)
        ]);
    }

    public function create($clientSlug)
    {
        $client = $this->getClient($clientSlug);

        $this->addBreadcrumbs($client, 'Create event');

        return view('pages.clients.manage.events.create', ['client' => $client]);
    }

    public function store($clientSlug, ClientEventCreateRequest $request)
    {
        $client = $this->getClient($clientSlug);

        $this->service->create($client, $request);

        return redirect()->route('clients.manage.events.index', $client->slug)->with('message', ['success', 'Event created']);
    }

    public function edit($clientSlug, $id)
    {
        $client = $this->getClient($clientSlug);

        $clientEvent = $this->service->get($client, $id);

        $this->addBreadcrumbs($client, 'Edit ' . $clientEvent->title);

        return view('pages.clients.manage.events.edit', [
            'client' => $client,
            'event' => $clientEvent,
        ]);
    }

    public function update($clientSlug, $id, ClientEventUpdateRequest $request)
    {
        $client = $this->getClient($clientSlug);

        $clientEvent = $this->service->get($client, $id);

        $this->service->update($clientEvent, $request);

        return redirect()->route('clients.manage.events.index', $client->slug)->with('message', ['success', 'Event updated']);
    }

    public function getDelete($clientSlug, $id)
    {
        $client = $this->getClient($clientSlug);

        $clientEvent = $this->service->get($client, $id);

        $this->addBreadcrumbs($client, 'Delete ' . $clientEvent->title);

        return view('pages.clients.manage.events.delete', [
            'event' => $clientEvent,
            'client' => $client
        ]);
    }

    public function destroy($clientSlug, $id)
    {
        $client = $this->getClient($clientSlug);

        $clientEvent = $this->service->get($client, $id);

        $this->service->delete($clientEvent);

        return redirect()->route('clients.manage.events.index', $client->slug)->with('message', ['success', 'Event deleted']);
    }

    private function getClient($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manageEvents', $client);

        return $client;
    }

    private function addBreadcrumbs(Client $client, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}