<?php

namespace Pi\Http\Controllers\Client;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Pi\Clients\ClientsService;
use Pi\Clients\Schedule\AdministratorScheduleService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Clients\Meetings\MeetingCreateRequest;
use Pi\Http\Requests\Clients\Meetings\QueryAvailableMeetingTimesRequest;

class ScheduleMeetingController extends Controller
{
    /**
     * @var AdministratorScheduleService
     */
    private $service;
    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(AdministratorScheduleService $service, ClientsService $clientsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
    }

    public function getIndex($clientSlug, QueryAvailableMeetingTimesRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        if(!$client->administrator->hasGoogleToken())
        {
            return redirect()->route('clients.show', [$client->slug])
                ->with('message', ['warning', 'Sorry, but meeting schedule currently unavailable']);
        }

        if($request->hasDate())
        {
            $date = $request->getDate();
        }
        else
        {
            $date = $this->service->findNearestAvailableScheduleDate(new Carbon());
        }

        return view('pages.clients.meeting.index', [
            'meetings' => $this->service->getArrangedMeetings($client),
            'client' => $client,
            'date' => $date,
            'times' => $this->service->getAvailableTimesForDay($client->administrator, $date)
        ]);
    }

    public function postIndex($clientSlug, MeetingCreateRequest $request, Guard $auth)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);

        if(!$client->administrator->hasGoogleToken())
        {
            return redirect()->route('clients.show', [$client->slug])
                ->with('message', ['warning', 'Sorry, but meeting schedule currently unavailable']);
        }

        $this->service->createMeeting($client, $auth->user(), $request);

        return redirect()->route('clients.show', [$client->slug])
            ->with('message', ['success', 'Meeting arranged']);
    }
}