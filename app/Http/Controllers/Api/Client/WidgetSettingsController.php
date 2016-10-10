<?php

namespace Pi\Http\Controllers\Api\Client;

use Pi\Clients\ClientsService;
use Pi\Clients\Settings\ClientWidgetSettingsService;
use Pi\Http\Controllers\Api\ApiController;
use Pi\Http\Requests\Clients\Settings\WidgetStoreRequest;

class WidgetSettingsController extends ApiController
{
    /**
     * @var ClientWidgetSettingsService
     */
    private $service;
    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(ClientWidgetSettingsService $service, ClientsService $clientsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
    }

    public function index($clientId)
    {
        $client = $this->clientsService->get($clientId);

        $this->authorize('manage', $client);

        return response()->json($this->service->get($client));
    }

    public function store($clientId, WidgetStoreRequest $request)
    {
        $client = $this->clientsService->get($clientId);

        $this->authorize('manage', $client);

        $this->service->store($client, $request->getWidgetSettings());

        return $this->responseSuccess([]);
    }
}