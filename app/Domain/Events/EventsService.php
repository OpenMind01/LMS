<?php

namespace Pi\Domain\Events;

use Carbon\Carbon;
use Pi\Exceptions\Events\InvalidDateTimes;
use Pi\Http\Requests\Events\EventCreateRequest;
use Pi\Http\Requests\Events\EventUpdateRequest;

class EventsService
{
    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return \Illuminate\Database\Eloquent\Collection|Event[]
     */
    public function getEvents(Carbon $start, Carbon $end)
    {
        return Event::where('start_datetime', '<=', $end)
            ->where('finish_datetime', '>=', $start)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Event::orderBy('start_datetime', 'desc');
    }

    /**
     * @param $id
     * @return Event
     */
    public function get($id)
    {
        return Event::findOrFail($id);
    }

    /**
     * @param EventCreateRequest $request
     * @return Event
     */
    public function create(EventCreateRequest $request)
    {
        $this->checkDateTimes($request->getStartDateTime(), $request->getFinishDateTime());

        $event = new Event();
        $event->title = $request->getTitle();
        $event->text = $request->getText();
        $event->start_datetime = $request->getStartDateTime();
        $event->all_day = $request->getAllDay();
        $event->finish_datetime = $request->getFinishDateTime();

        $event->save();

        return $event;
    }

    public function update(Event $event, EventUpdateRequest $request)
    {
        $this->checkDateTimes($request->getStartDateTime(), $request->getFinishDateTime());

        $event->title = $request->getTitle();
        $event->text = $request->getText();
        $event->start_datetime = $request->getStartDateTime();
        $event->all_day = $request->getAllDay();
        $event->finish_datetime = $request->getFinishDateTime();

        $event->save();
    }

    public function delete(Event $event)
    {
        $event->delete();
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