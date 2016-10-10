<?php

namespace Pi\Http\Controllers\Admin;

use Pi\Auth\Permission;
use Pi\Domain\Events\EventsService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Events\EventCreateRequest;
use Pi\Http\Requests\Events\EventUpdateRequest;
use Pi\Http\Requests\Industries\IndustryCreateRequest;
use Pi\Http\Requests\Industries\IndustryUpdateRequest;
use Pi\Domain\Industries\IndustriesService;
use Pi\Domain\Industries\Industry;
use Pi\Usergroups\UsergroupsService;

class EventsController extends Controller
{
    /**
     * @var EventsService
     */
    private $service;

    public function __construct(EventsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        return view('pages.admin.events.index', [
            'events' => $this->service->query()->paginate(25)
        ]);
    }

    public function create()
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        return view('pages.admin.events.create');
    }

    public function store(EventCreateRequest $request)
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        $this->service->create($request);

        return redirect()->route('admin.events.index')->with('message', ['success', 'Event created']);
    }

    public function edit($id)
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        $event = $this->service->get($id);

        return view('pages.admin.events.edit', [
            'event' => $event,
        ]);
    }

    public function update($id, EventUpdateRequest $request)
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        $event = $this->service->get($id);

        $this->service->update($event, $request);

        return redirect()->route('admin.events.index')->with('message', ['success', 'Event updated']);
    }

    public function getDelete($id)
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        return view('pages.admin.events.delete', [
            'event' => $this->service->get($id)
        ]);
    }

    public function destroy($id)
    {
        $this->authorize(Permission::EVENTS_MANAGE);

        $event = $this->service->get($id);

        $this->service->delete($event);

        return redirect()->route('admin.events.index')->with('message', ['success', 'Event deleted']);
    }
}