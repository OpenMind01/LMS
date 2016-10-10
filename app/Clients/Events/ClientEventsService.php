<?php

namespace Pi\Clients\Events;

use Carbon\Carbon;
use Pi\Clients\Client;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Exceptions\Events\InvalidDateTimes;
use Pi\Http\Requests\Clients\Events\ClientEventCreateRequest;
use Pi\Http\Requests\Clients\Events\ClientEventUpdateRequest;

class ClientEventsService
{
    /**
     * @param Client $client
     * @param Carbon $start
     * @param Carbon $end
     * @return array|\Illuminate\Database\Eloquent\Collection|ClientEvent[]
     */
    public function getClientEvents(Client $client, Carbon $start, Carbon $end)
    {
        return ClientEvent::whereClientId($client->id)
            ->where('start_datetime', '<=', $end)
            ->where('finish_datetime', '>=', $start)
            ->get();
    }


    /**
     * @param Client $client
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Client $client)
    {
        return ClientEvent::whereClientId($client->id)->orderBy('start_datetime', 'desc');
    }

    /**
     * @param Client $client
     * @param $id
     * @return ClientEvent
     * @throws EntityNotFoundException
     */
    public function get(Client $client, $id)
    {
        /**
         * @var ClientEvent $clientEvent
         */
        $clientEvent = ClientEvent::findOrFail($id);

        if($clientEvent->client_id != $client->id)
        {
            throw new EntityNotFoundException(self::class, 'id in client', $id . ' ' . $client->id);
        }

        return $clientEvent;
    }

    /**
     * @param Client $client
     * @param ClientEventCreateRequest $request
     * @return ClientEvent
     */
    public function create(Client $client, ClientEventCreateRequest $request)
    {
        $this->checkDateTimes($request->getStartDateTime(), $request->getFinishDateTime());

        $clientEvent = new ClientEvent();
        $clientEvent->client_id = $client->id;
        $clientEvent->title = $request->getTitle();
        $clientEvent->text = $request->getText();
        $clientEvent->start_datetime = $request->getStartDateTime();
        $clientEvent->all_day = $request->getAllDay();
        $clientEvent->finish_datetime = $request->getFinishDateTime();

        $clientEvent->save();

        return $clientEvent;
    }

    public function update(ClientEvent $clientEvent, ClientEventUpdateRequest $request)
    {
        $this->checkDateTimes($request->getStartDateTime(), $request->getFinishDateTime());

        $clientEvent->title = $request->getTitle();
        $clientEvent->text = $request->getText();
        $clientEvent->start_datetime = $request->getStartDateTime();
        $clientEvent->all_day = $request->getAllDay();
        $clientEvent->finish_datetime = $request->getFinishDateTime();

        $clientEvent->save();
    }

    public function delete(ClientEvent $clientEvent)
    {
        $clientEvent->delete();
    }

    private function checkDateTimes(Carbon $start, Carbon $finish)
    {
        if($finish == null) return;

        if($finish < $start)
        {
            throw new InvalidDateTimes();
        }
    }
}