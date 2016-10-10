<?php

namespace Pi\Http\Controllers\Client\Management;

use Pi\Clients\ClientsService;
use Pi\Clients\Theme\Theme;
use Pi\Clients\Theme\ThemesService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Theme\ClientThemeUpdateRequest;

class ClientThemeController extends Controller
{
    private $routePrefix = 'clients.manage.theme.';

    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * @var ThemesService
     */
    private $themesService;

    public function __construct(ClientsService $clientsService, ThemesService $themesService)
    {
        $this->clientsService = $clientsService;
        $this->themesService = $themesService;
    }

    public function index($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle('Theme');

        return view('pages.clients.manage.theme.index', [
            'client' => $client,
            'routePrefix' => $this->routePrefix,
            'fonts' => Theme::getAvailableFonts(),
            'styleNames' => Theme::getStyleNames(),
            'styleTypes' => Theme::getStyleTypes(),
        ]);
    }

    public function store($clientSlug, ClientThemeUpdateRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->themesService->update($client->theme, $request);

        return redirect()->route('clients.show', ['clientSlug' => $clientSlug])->with('message', ['success', 'Theme successfully updated.']);
    }
}