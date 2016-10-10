<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 5:18 PM
 */

namespace Pi\Http\Controllers\Client;


use Pi\Http\Controllers\Controller;
use Pi\Clients\Client;
use Pi\Clients\Courses\Repositories\CourseUserRepository;

class CourseController extends Controller
{

    public function show($clientSlug, $courseSlug)
    {
        $client = Client::whereSlug($clientSlug)->first();

        $this->authorize('member', $client);

        $course = $client->courses()
            ->with(['modules.articles' => function($q) {
                $q->with('watchActions.users', 'listenActions.users', 'module.course', 'quizzes.attempts');
            },  'client', 'users'])
            ->whereSlug($courseSlug)->first();

        if(\Auth::User()->isAdmin()){
            $courseUsers = new CourseUserRepository;
            $courseUsers->addUserToCourse(\Auth::User(), $course);
        }

//        $this->authorize('member', $course);

        return view('pages.clients.courses.show', compact('client', 'course'));
    }
}