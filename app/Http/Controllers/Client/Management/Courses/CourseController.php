<?php
/**
 * Created by Justin McCombs.
 * Date: 11/4/15
 * Time: 9:30 AM
 */

namespace Pi\Http\Controllers\Client\Management\Courses;


use Illuminate\Http\Request;
use Pi\Auth\Permission;
use Pi\Clients\Client;
use Pi\Clients\ClientsService;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Domain\Requests\Usergroups\PlainUsergroupCreateRequest;
use Pi\Http\Controllers\Controller;
use Pi\Importing\Word\WordImporter;
use Pi\Utility\Assets\AssetStorageService;
use Pi\Http\Requests\Clients\Courses\CourseCloneRequest;
use Pi\Usergroups\UsergroupsService;

class CourseController extends Controller
{
    /**
     * @var CoursesService
     */
    private $service;

    /**
     * @var ClientsService
     */
    private $clientsService;

    public function __construct(CoursesService $service, ClientsService $clientsService)
    {
        $this->service = $service;
        $this->clientsService = $clientsService;
    }

    public function index($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Course), $client]);
        $courses = $client->courses()->with('modules.articles.quizzes')->get();

        $this->addBreadcrumbs($client);

        return view('pages.clients.manage.courses.index', compact('client', 'courses'));
    }

    public function create($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Course), $client]);

        $this->addBreadcrumbs($client, 'Create');

        return view('pages.clients.manage.courses.create', compact('client'));
    }

    public function store(Request $request, $clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Course), $client]);
        $this->validate($request, Course::rules(null, $client->id));
        $course = Course::create($request->all());
        return redirect()->route('clients.manage.courses.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully created a new course: '. $course->name.'.']);
    }

    public function storeWithFile(Request $request, WordImporter $wordImporter, AssetStorageService $assetStorage, $clientSlug)
    {
        // Create course.
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Course), $client]);
        $this->validate($request, Course::rules(null, $client->id));
        $values = array(
            "_token" => $request->input('_token'),
            "client_id" => $request->input('client_id'),
            "name" => $request->input('name'),
            "description" => $request->input('description'),
        );
//        $course = Course::create($values);

        // Read the posted file and stored in a temporary location.
        $file = $request->file('file');
        $path = sys_get_temp_dir().'/'.$file->getClientOriginalName();
        $file->move(sys_get_temp_dir(), $file->getClientOriginalName());

        // Parse the file using the importer.
        $wordImporter->setFilePath($path);
        try {
            $wordImporter->import();
        }catch(FiletypeNotSupportedException $e)
        {
            return redirect()->back()->withInput($request->all())->with('message', ['warning', 'That file type is not supported.  Please upload a .docx file.']);
        }

        $course = $wordImporter->getCourse($client, $request->get('name'));

        $wordImporter->getImages()->each(function($localpath) use ($assetStorage, $course) {
            $assetStorage->attachAssetFromPath($course, $localpath, 'image');
        });

        return redirect()->route('clients.manage.courses.index', [$client->slug])->with('message', ['success', 'Course Imported.']);

        // Print the file's content in a view.
        return view('pages.clients.manage.courses.import-edit', compact('slides', 'images', 'title', 'client', 'courseId'));
    }

    public function importModule(Request $request, WordImporter $wordImporter, AssetStorageService $assetStorage, $clientSlug, $courseSlug)
    {
        // Get client and course.
        $course = Course::whereSlug($courseSlug)->first();
        $client = Client::whereSlug($clientSlug)->first();

		// Read the posted file and stored in a temporary location.
        $file = $request->file('file');
        $path = sys_get_temp_dir().'/'.$file->getClientOriginalName();
        $file->move(sys_get_temp_dir(), $file->getClientOriginalName());

		// Parse the file using the importer.
        $wordImporter->setFilePath($path);
        try {
            $wordImporter->import();
        }catch(FiletypeNotSupportedException $e)
        {
            return redirect()->back()->withInput($request->all())->with('message', ['warning', 'That file type is not supported.  Please upload a .docx file.']);
        }

        // Save file's images.
        //$wordImporter->getImages()->each(function($localpath) use ($assetStorage, $course) {
        //    $assetStorage->attachAssetFromPath($course, $localpath, 'image');
        //});

		// Define template variables.
        $slides = $wordImporter->getSlides();
		$title = $request->input('name');

        $this->addBreadcrumbs($client, 'Import module');

		// Print the file's content in a view.
		return view('pages.clients.manage.courses.import_module', compact('slides', 'images', 'title', 'client', 'course'));
    }

    public function saveModulesAndLessons(Request $request, $clientSlug, $courseSlug)
    {
        // Get client and course.
        $course = Course::whereSlug($courseSlug)->first();
        $client = Client::whereSlug($clientSlug)->first();

        dd($request->all());

		// Parse input parameters.
		$params = $request->all();
		$items = $params['items'];

        // Get the highest module number.
        $baseModuleNumber = 0;
        foreach ($course->modules as $module) {
            if($module->number > $baseModuleNumber) {
                $baseModuleNumber = $module->number;
            }
        }

		// Save modules and articles.
		$res = array("result" => "ok");
		try {
			$lastModuleId = null;
			foreach($items as $item) {
				// Verify if a module or an article.
				if(strcasecmp($item['type'], 'module') == 0) {
					// Save module.
					$values = array(
						"_token" => $request->input('_token'),
						"client_id" => $client->id,
						"course_id" => $course->id,
						"number" => ($item['number'] + $baseModuleNumber),
						"name" => $item['name'],
					);
					$module = Module::create($values);
					$lastModuleId = $module->id;
				} else {
					// Save article if a module was previously saved.
					if(is_int($lastModuleId)) {
						$values = array(
							"_token" => $request->input('_token'),
							"client_id" => $client->id,
							"module_id" => $lastModuleId,
							"number" => $item['number'],
							"name" => $item['name'],
							"body" => $item['body']
						);

						$article = Article::create($values);
					}
				}

			}
		}catch(Exception $e) {
			$res = array("result" => "error", "message" => $e);
		}

		// Return result.
		return json_encode($res);
    }

    public function edit($clientSlug, $slug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($slug)->with('modules')->first();
        $this->authorize('manage', [$course, $client]);
        if ( ! $course )
            return redirect()->back()->with('message', ['danger', 'Could not find the course.']);

        $this->addBreadcrumbs($client, 'Edit ' . $course->name);

        return view('pages.clients.manage.courses.edit', compact('course', 'client'));
    }

    public function import($clientSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $this->authorize('manage', [(new Course), $client]);

        $this->addBreadcrumbs($client, 'Import course');

        return view('pages.clients.manage.courses.import', compact('client'));
    }

    /**
     * Updates a Course
     * @param Request $request
     * @param $clientSlug
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereId($id)->first();
        if ( ! $course )
            return redirect()->back()->with('message', ['danger', 'Could not find the course.']);
        $this->authorize('manage', $course);
        $this->validate($request, Course::rules($course->id, $course->client_id));
        $course->update($request->all());
        return redirect()->route('clients.manage.courses.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Successfully updated the course '.$course->name.'.']);
    }

    public function destroy($clientSlug, $courseSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        if ( ! $course )
            return redirect()->back()->with('message', ['danger', 'Could not find the course.']);
        $course->delete();
        return redirect()->back()->with('message', ['success', 'Course was removed.']);
    }

    public function postModuleOrder(Request $request, $clientSlug, $id)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = Course::find($id);
        $this->authorize('manage', [$course, $client]);
        if ( ! $course )
            return response()->json(['success' => false]);

        $order = $request->get('order');
        $returnOrder = [];
        foreach($order as $i => $moduleId)
        {
            $course->modules()->whereId($moduleId)->update(['number' => $i+1]);
            $returnOrder[$i+1] = $moduleId;
        }

        return response()->json(['success' => true, 'order' => $returnOrder]);
    }

    public function getClone($clientSlug, $slug)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);
        $this->authorize('manage', $client);

        $clients = $this->clientsService->getClientsAllowedToModerate(\Auth::user());
        $clientsToManage = [];

        if (!empty($clients))
        {
            $clientsToManage = ['' => ''];
            foreach ($clients as $cl)
            {
                $clientsToManage[$cl->id] = $cl->name;
            }
        }

        $this->addBreadcrumbs($client, 'Clone course');

        return view('pages.clients.manage.courses.clone', [
            'client' => $client,
            'clientsToManage' => $clientsToManage,
            'course' => $this->service->getBySlug($client, $slug)
        ]);
    }

    public function postClone($clientSlug, $slug, CourseCloneRequest $request)
    {
        $client = $this->clientsService->getClientBySlug($clientSlug);
        $this->authorize('manage', $client);

        $course = $this->service->getBySlug($client, $slug);


        // If there is a client_id and user has access to the target client -> clone the course to another client; Otherwise clone the course to the same client.
        $targetClient = $request->getClientId();
        if (!empty($targetClient))
        {
            $targetClient = $this->clientsService->get($targetClient);
            $this->authorize('manage', $targetClient);
            $clientSlug = $targetClient->slug;
        }
        else
        {
            $targetClient = $client;
        }


        $this->service->cloneCourse($course, $targetClient, $request);

        return redirect()->route('clients.manage.courses.index', ['clientSlug' => $clientSlug])->with('message', ['success', 'Course successfully cloned.']);
    }

    public function getCreateUsergroup($clientSlug, $slug)
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $client = $this->clientsService->getClientBySlug($clientSlug);
        $course = $this->service->getBySlug($client, $slug);

        $this->addBreadcrumbs($client, 'Create user group from course');

        return view('pages.clients.manage.courses.usergroup', [
            'client' => $client,
            'course' => $course,
            'defaultTitle' => trim(str_replace('User group:', '', $course->name))
        ]);
    }

    public function postCreateUsergroup($clientSlug, $slug, UsergroupsService $usergroupsService, CourseCloneRequest $request)
    {
        $this->authorize(Permission::USERGROUPS_MANAGE);

        $client = $this->clientsService->getClientBySlug($clientSlug);
        $course = $this->service->getBySlug($client, $slug);

        $clonedCourse = $this->service->cloneCourse($course, $usergroupsService->getUsergroupsClient(), $request);
        $usergroup = $usergroupsService->create(new PlainUsergroupCreateRequest($request->getName(), $clonedCourse->id));

        return redirect()->route('admin.usergroups.edit', ['id' => $usergroup->id])
            ->with('message', ['success', 'User group created']);
    }

    public function getStructure($clientSlug, $slug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($slug)->with('modules.articles')->first();
        $this->authorize('manage', [$course, $client]);
        if ( ! $course )
            return redirect()->back()->with('message', ['danger', 'Could not find the course.']);

        $this->addBreadcrumbsWithCourse($client, $course, 'Edit course structure');

        return view('pages.clients.manage.courses.structure', compact('client', 'course'));
    }

    private function addBreadcrumbs(Client $client, $title = null)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->add(route('clients.manage.courses.index', [$client->slug]), 'Courses');

        if($title != null)
        {
            $this->breadcrumbsHelper->addTitle($title);
        }
    }

    private function addBreadcrumbsWithCourse(Client $client, Course $course, $title)
    {
        $this->breadcrumbsHelper->addClientLink($client);
        $this->breadcrumbsHelper->addManagementCourseLink($course, $client);
        $this->breadcrumbsHelper->addTitle($title);
    }
}