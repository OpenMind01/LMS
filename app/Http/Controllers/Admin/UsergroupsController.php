<?php

namespace Pi\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Guard;
use Pi\Auth\Permission;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Http\Controllers\Controller;
use Pi\Http\Requests\Usergroups\UsergroupCreateRequest;
use Pi\Http\Requests\Usergroups\UsergroupUpdateRequest;
use Pi\Domain\Industries\IndustriesService;
use Pi\Usergroups\UsergroupsService;

class UsergroupsController extends Controller
{
    /**
     * @var UsergroupsService
     */
    private $service;

    /**
     * @var IndustriesService
     */
    private $industriesService;

    /**
     * @var CoursesService
     */
    private $coursesService;

    /**
     * UsergroupsController constructor.
     * @param UsergroupsService $service
     * @param IndustriesService $industriesService
     * @param CoursesService $coursesService
     */
    public function __construct(UsergroupsService $service, IndustriesService $industriesService, CoursesService $coursesService)
    {
        $this->service = $service;
        $this->industriesService = $industriesService;
        $this->coursesService = $coursesService;
    }

    public function index()
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $usergroups = $this->service->query()->paginate(25);

        return view('pages.admin.usergroups.index', compact('usergroups'));
    }

    public function create()
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $courses = $this->service->getAllowedCourses();

        $coursesList = [];
        foreach($courses as $course)
        {
            $coursesList[$course->id] = $course->name;
        }

        return view('pages.admin.usergroups.create', compact('coursesList'));
    }

    public function store(UsergroupCreateRequest $request)
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $usergroup = $this->service->create($request);

        return redirect()->route('admin.usergroups.edit', ['id' => $usergroup->id])
            ->with('message', ['success', 'User group created']);
    }

    public function edit($id)
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $usergroup = $this->service->get($id);

        $usergroupModules = $this->service->getUsergroupModules($usergroup);
        $currentModulesList = [];
        $currentArticlesList = [];
        foreach($usergroupModules as $usergroupModule)
        {
            $currentModulesList[$usergroupModule->module_id] = 1;
            foreach($usergroupModule->articles as $usergroupArticle)
            {
                $currentArticlesList[$usergroupArticle->article_id] = 1;
            }
        }

        $possibleModules = $this->service->getPossibleModules($usergroup);

        $industriesList = $this->industriesService->query()->get();
        $currentIndustries = $usergroup->industries->getDictionary();

        return view('pages.admin.usergroups.edit',
            compact('usergroup', 'currentModulesList', 'currentArticlesList', 'possibleModules',
                'industriesList', 'currentIndustries'));
    }

    public function update($id, UsergroupUpdateRequest $request)
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $usergroup = $this->service->get($id);

        $this->service->update($usergroup, $request);

        return redirect()->route('admin.usergroups.index')
            ->with('message', ['success', 'User group updated']);
    }
}