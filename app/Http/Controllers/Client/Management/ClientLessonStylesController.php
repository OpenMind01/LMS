<?php

namespace Pi\Http\Controllers\Client\Management;

use Pi\Clients\ClientsService;
use Pi\Clients\LessonStyles\LessonStyles;
use Pi\Clients\Theme\Theme;
use Pi\Http\Controllers\Controller;

class ClientLessonStylesController extends Controller
{
    private $routePrefix = 'clients.manage.lesson-styles.';

    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
    }

    public function index($clientSlug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        $this->authorize('manage', $client);

        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addTitle('Lesson Styles');

        return view('pages.clients.manage.lesson-styles.index', [
            'client' => $client,
            'routePrefix' => $this->routePrefix,
            'fonts' => Theme::getAvailableFonts()
        ]);
    }

    public function store(){

    }

}
