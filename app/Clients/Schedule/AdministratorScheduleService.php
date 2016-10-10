<?php

namespace Pi\Clients\Schedule;

use Carbon\Carbon;
use Illuminate\Database\Query\Expression;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Http\Requests\Clients\Meetings\MeetingCreateRequest;
use Pi\Services\GoogleCalendar;

class AdministratorScheduleService
{
    /**
     * @var GoogleCalendar
     */
    private $googleCalendar;

    public function __construct(GoogleCalendar $googleCalendar)
    {
        $this->googleCalendar = $googleCalendar;
    }

    /**
     * @param Carbon $start
     * @return Carbon
     */
    public function findNearestAvailableScheduleDate(Carbon $start)
    {
        $current = clone $start;

        $nextDay = function(Carbon $date) {
            $date->addDay();
            $date->hour(8);
        };

        if($current->hour > 16)
        {
            $nextDay($current);
        }

        while($current->isWeekend())
        {
            $nextDay($current);
        }

        return $current;
    }

    public function getArrangedMeetings(Client $client)
    {
        return Meeting::whereClientId($client->id)
            ->where('start_at', '>', new Expression('NOW()'))
            ->orderBy('start_at')
            ->get();
    }

    /**
     * @param Client $client
     * @param User $user
     * @param MeetingCreateRequest $request
     * @return Meeting
     */
    public function createMeeting(Client $client, User $user, MeetingCreateRequest $request)
    {
        $start = $request->getDateTime();
        $end = clone $start;
        $end->addHour();

        $service = $this->googleCalendar->createCalendarService($client->administrator->google_token);

        $event = $service->events->insert('primary', new \Google_Service_Calendar_Event([
            'summary' => 'Meeting with ' . $client->name . '(' . $request->getReason() . ')',
            'description' => 'Automatically arranged meeting',
            'start' => array(
                'dateTime' => $start->format(Carbon::RFC3339),
            ),
            'end' => array(
                'dateTime' => $end->format(Carbon::RFC3339),
            ),
            'attendees' => array(
                array('email' => $user->email),
                array('email' => $client->administrator->email),
            ),
        ]));

        $meeting = new Meeting();
        $meeting->client_id = $client->id;
        $meeting->user_id = $user->id;
        $meeting->administrator_id = $client->administrator_id;
        $meeting->start_at = $start;
        $meeting->reason = $request->getReason();
        $meeting->google_event_id = $event->getId();

        $meeting->save();

        return $meeting;
    }

    /**
     * @param User $administrator
     * @param Carbon $date
     * @return AvailableMeetingTime[]
     */
    public function getAvailableTimesForDay(User $administrator, Carbon $date)
    {
        $start = clone $date;
        $start->hour(0);

        $end = clone $date;
        $end->hour(23);

        return $this->getAvailableTimes($administrator, $start, $end);
    }

    /**
     * @param User $administrator
     * @param Carbon $start
     * @param Carbon $end
     * @return AvailableMeetingTime[]
     */
    public function getAvailableTimes(User $administrator, Carbon $start, Carbon $end)
    {
        $googleEvents = $this->getGoogleEvents($administrator, $start, $end);
        $schedule = $this->getSchedule($administrator, $start, $end);

        foreach($googleEvents as $googleEvent)
        {
            $keysToDelete = [];
            foreach($schedule as $key => $availableMeetingTime)
            {
                if($availableMeetingTime->getStartDateTime() > $googleEvent->getEndDateTime()) break;

                if($availableMeetingTime->getStartDateTime() < $googleEvent->getEndDateTime()
                    && $availableMeetingTime->getStartDateTime() >= $googleEvent->getStartDateTime())
                {
                    $keysToDelete[] = $key;
                    continue;
                }

                if($availableMeetingTime->getEndDateTime() > $googleEvent->getStartDateTime()
                    && $availableMeetingTime->getEndDateTime() <= $googleEvent->getEndDateTime())
                {
                    $keysToDelete = [];
                }
            }

            foreach($keysToDelete as $key)
            {
                unset($schedule[$key]);
            }
        }

        return array_values($schedule);
    }

    /**
     * @param User $administrator
     * @param Carbon $start
     * @param Carbon $end
     * @return GoogleCalendarEvent[]
     */
    private function getGoogleEvents(User $administrator, Carbon $start, Carbon $end)
    {
        $service = $this->googleCalendar->createCalendarService($administrator->google_token);

        $optParams = array(
            'maxResults' => 1000,
            'orderBy' => 'startTime',
            'singleEvents' => TRUE,
            'timeMin' => $start->format(Carbon::RFC3339),
            'timeMax' => $end->format(Carbon::RFC3339),
        );

        $googleEvents = $service->events->listEvents('primary', $optParams);

        /**
         * @var \Google_Service_Calendar_Event[] $items
         */
        $items = $googleEvents->getItems();
        $events = [];
        foreach ($items as $googleServiceCalendarEvent)
        {
            $events[] = new GoogleCalendarEvent(
                $googleServiceCalendarEvent->getSummary(),
                Carbon::createFromFormat(Carbon::RFC3339, $googleServiceCalendarEvent->getStart()->getDateTime()),
                Carbon::createFromFormat(Carbon::RFC3339, $googleServiceCalendarEvent->getEnd()->getDateTime()));
        }

        return $events;
    }

    /**
     * @param User $administrator
     * @param Carbon $start
     * @param Carbon $end
     * @return AvailableMeetingTime[]
     */
    private function getSchedule(User $administrator, Carbon $start, Carbon $end)
    {
        $current = $start;
        $events = [];
        $now = new Carbon();
        $i = 0;
        while($current->timestamp <= $end->timestamp)
        {
            // Don't allow meetings at weekend
            if($current->isWeekend())
            {
                $current->addDay();
                continue;
            }

            foreach (range(9, 17, 1) as $hour)
            {
                $startDateTime = Carbon::create($current->year, $current->month, $current->day, $hour, 0, 0);
                $endDateTime = Carbon::create($current->year, $current->month, $current->day, $hour + 1, 0, 0);

                if($startDateTime < $now) continue;
                if($startDateTime < $start) continue;
                if($endDateTime > $end) break;

                $events[] = new AvailableMeetingTime($startDateTime, $endDateTime);
            }

            $current->addDay();
        }

        //print $start . ' - '. $end; exit;

        return $events;
    }
}