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
use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Clients\Courses\Services\UserProgressService;
use Pi\Domain\Requests\Usergroups\PlainUsergroupCreateRequest;
use Pi\Http\Controllers\Controller;
use Pi\Importing\Word\WordImporter;
use Pi\Utility\Assets\AssetStorageService;
use Pi\Http\Requests\Clients\Courses\CourseCloneRequest;
use Pi\Usergroups\UsergroupsService;

class CourseUsersController extends Controller
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

    public function index($clientSlug, $courseSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);

        $this->addBreadcrumbs($client);

        $client->load('users');

        return view('pages.clients.manage.courses.users.index', compact('client', 'course'));
    }

    public function show($clientSlug, $courseSlug, $userId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        // Eager load is sort of crazy due to how course progress is generated.
        // TODO: move this to a service or a scope.
        $course = $client->courses()->whereSlug($courseSlug)->with(['modules.articles.doQuiz', 'modules.articles.answerQuiz', 'modules.articles.module.articles', 'modules.articles.module.course.users','modules.articles.watchActions', 'modules.articles.listenActions', 'modules.course.users', 'modules.articles.quizzes' => function ($q) {
            $q->with(['attempts', 'elements.responses']);
        }])->first();
        $this->authorize('manage', [$course, $client]);
        $this->addBreadcrumbs($client);
        $user = $course->users->filter(function($user) use ($userId) {return ($user->id == $userId); })->first();
        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);

        return view('pages.clients.manage.courses.users.show', compact('client', 'course', 'user'));
    }

    public function showQuiz($clientSlug, $courseSlug, $userId, $quizId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        // Eager load is sort of crazy due to how course progress is generated.
        // TODO: move this to a service or a scope.
        $course = $client->courses()->whereSlug($courseSlug)->with(['modules.articles.doQuiz', 'modules.articles.answerQuiz', 'modules.articles.module.articles', 'modules.articles.module.course.users','modules.articles.watchActions', 'modules.articles.listenActions', 'modules.course.users', 'modules.articles.quizzes' => function ($q) {
            $q->with(['attempts', 'elements.responses']);
        }])->first();
        $this->authorize('manage', [$course, $client]);
        $this->addBreadcrumbs($client);
        $user = $course->users->filter(function($user) use ($userId) {return ($user->id == $userId); })->first();
        if ( ! $user )
            return redirect()->back()->with('message', ['danger', 'Could not find the user.']);
        $quiz = Quiz::where('client_id', '=', $client->id)
            ->whereId($quizId)
            ->with(['elements', 'responses' => function($q) use ($user) {
                $q->where('user_id', '=', $user->id)->with('quizElement.options');
            }])
            ->first();
        if ( ! $quiz )
            return redirect()->back()->with('message', ['danger', 'Could not find the quiz.']);

        return view('pages.clients.manage.courses.users.show-quiz', compact('client', 'course', 'user', 'quiz'));
    }

    public function resetProgress(UserProgressService $userProgress, $clientSlug, $courseSlug, $userId)
    {
        $client = Client::whereSlug($clientSlug)->first();
        $this->authorize('manage', $client);
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $this->authorize('manage', [$course, $client]);
        $user = $course->users()->where('user_id', $userId)->first();
        if ( ! $user) return redirect()->back()->with('message', ['danger', 'User does not belong to course.']);

        if ($userProgress->resetUserProgressForCourse($course, $user)) {
            return redirect()->back()->with('message', ['success', 'Progress reset for user ' . $user->full_name]);
        }

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