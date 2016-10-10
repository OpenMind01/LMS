<?php

namespace Pi\Domain\Calendar;

use Carbon\Carbon;
use Pi\Auth\User;
use Pi\Clients\Events\ClientEventsService;
use Pi\Clients\Milestones\MilestonesService;
use Pi\Domain\Calendar\CalendarEntry;
use Pi\Domain\Events\EventsService;

class CalendarService
{
    /**
     * @var MilestonesService
     */
    private $milestonesService;
    /**
     * @var ClientEventsService
     */
    private $clientsEventService;
    /**
     * @var EventsService
     */
    private $eventsService;

    public function __construct(MilestonesService $milestonesService,
                                ClientEventsService $clientEventService,
                                EventsService $eventService)
    {
        $this->milestonesService = $milestonesService;
        $this->clientsEventService = $clientEventService;
        $this->eventsService = $eventService;
    }

    /**
     * @param User $user
     * @param Carbon $start
     * @param Carbon $end
     * @returns array
     */
    public function getCalendarEventsForUser(User $user, Carbon $start, Carbon $end)
    {
        $events = $this->getUserEvents($user, $start, $end);

        $res = [];
        foreach($events as $event)
        {
            $res[] = [
                'id' => $event->getCalendarId(),
                'title' => $event->getCalendarTitle(),
                'allDay' => $event->getCalendarAllDay(),
                'start' => $event->getCalendarStart()->format('Y-m-d'),
                'end' => $event->getCalendarEnd()->format('Y-m-d'),
            ];
        }

        return $res;
    }

    /**
     * @param User $user
     * @param Carbon $start
     * @param Carbon $end
     * @return CalendarEntry[]
     */
    public function getUserEvents(User $user, Carbon $start, Carbon $end)
    {
        return array_merge($this->milestonesService->getUserMilestones($user, $start, $end)->all(),
            $this->clientsEventService->getClientEvents($user->client, $start, $end)->all(),
            $this->eventsService->getEvents($start, $end)->all());
    }
}