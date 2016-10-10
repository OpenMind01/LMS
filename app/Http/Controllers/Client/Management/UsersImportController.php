<?php

namespace Pi\Http\Controllers\Client\Management;

use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Clients\Users\UsersImporter;
use Pi\Clients\Users\UsersImportService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Users\Import\ImportCreateRequest;
use Pi\Http\Requests\Clients\Users\Import\ImportProcessRequest;

class UsersImportController extends Controller
{
    /**
     * @var UsersImportService
     */
    private $importService;

    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(UsersImportService $importService, ClientsService $clientsService)
    {
        $this->importService = $importService;
        $this->clientsService = $clientsService;
    }

    public function getIndex($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, 'Users import');

        return view('pages.clients.manage.import.index', [
            'client' => $client,
            'delimiters' => $this->importService->getPossibleDelimiters(),
        ]);
    }

    public function postIndex($clientSlug, ImportCreateRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $import = $this->importService->create($client, $request);

        return redirect()->action('Client\Management\UsersImportController@getProcess', [$client->slug, $import->id]);
    }

    public function getProcess($clientSlug, $id, UsersImporter $usersImporter)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->addBreadcrumbs($client, 'Users import');

        $import = $this->importService->get($id);

        return view('pages.clients.manage.import.import', [
            'client' => $client,
            'import' => $import,
            'columnsData' => $this->importService->getColumnsData($import),
            'columnTypes' => $usersImporter->getPossibleColumns(),
        ]);
    }

    public function postProcess($clientSlug, $id, ImportProcessRequest $request, UsersImporter $usersImporter)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $import = $this->importService->get($id);

        $users = $usersImporter->process($client, $import, $request);

        $this->importService->delete($import);

        return redirect()->route('clients.show', $client->slug)->with('message', ['success', 'Users imported: ' . count($users)]);
    }

    public function getCancel($clientSlug, $id)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $import = $this->importService->get($id);

        $this->importService->delete($import);

        return redirect()->route('clients.show', $client->slug);
    }

    private function addBreadcrumbs(Client $client, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}