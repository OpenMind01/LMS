<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 2:42 PM
 */

namespace Pi\Http\Controllers\Client;


use Pi\Clients\Client;
use Pi\Clients\ClientActivationService;
use Pi\Clients\ClientsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Activation\MainRequest;
use Pi\Http\Requests\Clients\Activation\IndustriesRequest;
use Pi\Http\Requests\Clients\Activation\UsergroupsRequest;
use Pi\Domain\Industries\IndustriesService;
use Pi\Usergroups\UsergroupsService;

class ActivationController extends Controller
{
    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * @var ClientActivationService
     */
    private $service;

    public function __construct(ClientActivationService $service, ClientsService $clientsService)
    {
        $this->clientsService = $clientsService;
        $this->service = $service;
    }

    public function getIndex($slug)
    {
        $client = $this->getClient($slug);

        if($client->active)
        {
            return redirect()->route('clients.show', $client->slug);
        }

        return redirect()->action('Client\ActivationController@getMain', $client->slug);
    }

    public function getMain($slug)
    {
        $client = $this->getClient($slug);

        return view('pages.clients.activation.main', compact('client'));
    }

    public function postMain($slug, MainRequest $request)
    {
        $client = $this->getClient($slug);

        $this->service->activateMain($client, $request);

        return redirect()->action('Client\ActivationController@getIndustries', $client->slug);
    }

    public function getIndustries($slug, IndustriesService $industriesService)
    {
        $client = $this->getClient($slug);

        $industriesList = $industriesService->queryOpen()->get();
        $currentIndustries = $client->industries->getDictionary();

        return view('pages.clients.activation.industries', compact('client', 'industriesList', 'currentIndustries'));
    }

    public function postIndustries($slug, IndustriesRequest $request)
    {
        $client = $this->getClient($slug);

        $this->service->activateIndustries($client, $request);

        return redirect()->action('Client\ActivationController@getUsergroups', $client->slug);
    }

    public function getUsergroups($slug, UsergroupsService $usergroupsService)
    {
        $client = $this->getClient($slug);

        $usergroupsList = $usergroupsService->getOpenUsergroups($client->industries->lists('id')->toArray());
        $currentUsergroups = $client->usergroups->getDictionary();

        if(count($usergroupsList) == 0)
        {
            //Empty industries?
            return redirect()->action('Client\ActivationController@getIndustries', $client->slug);
        }

        return view('pages.clients.activation.usergroups', compact('client', 'usergroupsList', 'currentUsergroups'));
    }

    public function postUsergroups($slug, UsergroupsRequest $request)
    {
        $client = $this->getClient($slug);

        $this->service->activateUsergroups($client, $request);

        return redirect()->action('Client\ActivationController@getIndex', $client->slug);
    }

    /**
     * @param $slug
     * @return Client
     * @throws \Pi\Exceptions\EntityNotFoundException
     */
    private function getClient($slug)
    {
        $client = $this->clientsService->getClientBySlug($slug);

        $this->authorize('activate', $client);

        return $client;
    }
}