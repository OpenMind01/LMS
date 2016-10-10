<?php

namespace Pi\Http\Controllers\Admin;

use Pi\Auth\Permission;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Industries\IndustryCloneRequest;
use Pi\Http\Requests\Industries\IndustryCreateRequest;
use Pi\Http\Requests\Industries\IndustryUpdateRequest;
use Pi\Domain\Industries\IndustriesService;
use Pi\Domain\Industries\Industry;
use Pi\Usergroups\UsergroupsService;

class IndustriesController extends Controller
{
    /**
     * @var IndustriesService
     */
    private $service;

    public function __construct(IndustriesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        $industries = $this->service->query()->paginate(25);
        return view('pages.admin.industries.index', compact('industries'));
    }

    public function create(UsergroupsService $usergroupsService)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        return view('pages.admin.industries.create', [
            'usergroupsList' => $usergroupsService->query()->get(),
            'currentUsergroups' => [],
        ]);
    }

    public function store(IndustryCreateRequest $request)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        $this->service->create($request);

        return redirect()->route('admin.industries.index')->with('message', ['success', 'Industry created']);
    }

    public function edit($id, UsergroupsService $usergroupsService)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        $industry = $this->service->get($id);

        return view('pages.admin.industries.edit', [
            'industry' => $industry,
            'usergroupsList' => $usergroupsService->query()->get(),
            'currentUsergroups' => $industry->usergroups->getDictionary()
        ]);
    }

    public function update($id, IndustryUpdateRequest $request)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        $industry = $this->service->get($id);

        $this->service->update($industry, $request);

        return redirect()->route('admin.industries.index')->with('message', ['success', 'Industry updated']);
    }

    //-----------------------------------------------
    // Clone
    //-----------------------------------------------

    public function getClone($id)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        return view('pages.admin.industries.clone', [
            'industry' => $this->service->get($id)
        ]);
    }

    public function postClone($id, IndustryCloneRequest $request)
    {
        $this->authorize(Permission::INDUSTRIES_MANAGE);

        $industry = $this->service->get($id);

        $this->service->cloneFromOtherIndustry($industry, $request);

        return redirect()->route('admin.industries.index')->with('message', ['success', 'Industry cloned']);
    }
}