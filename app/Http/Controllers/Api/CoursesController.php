<?php
/**
 * Created by Justin McCombs.
 * Date: 10/14/15
 * Time: 4:54 PM
 */

namespace Pi\Http\Controllers\Api;


use Illuminate\Http\Request;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Repositories\CourseUserRepository;
use Pi\Http\Controllers\Controller;

class CoursesController extends ApiController
{

    public function inlineUpdate(Request $request, $id)
    {

        $course = Course::find($id);

        if ( ! $course )
            return response()->json(['success' => false]);

        $this->authorize('manage', $course);

        $attributes = [];

        foreach(json_decode($request->get('raptor-content')) as $field => $value)
        {
            $attributes[$field] = $value;
        }

        $course->update($attributes);


        return response()->json([
            'success' => true,
        ]);
    }

    public function addUser(Request $request, CourseUserRepository $courseUsers, $id)
    {
        $course = Course::find($id);

        if ( ! $course )
            return $this->responseError('Cannot find course.');

        $user = $course->client->users()->where('id', '=', $request->get('user_id'))->first();

        if ( ! $user )
            return $this->responseError('Cannot find user.');

        $courseUsers->addUserToCourse($user, $course);

        return $this->responseSuccess($user);
    }

    public function removeUser(Request $request, CourseUserRepository $courseUsers, $id, $userId)
    {
        $course = Course::find($id);

        if ( ! $course )
            return $this->responseError('Cannot find course.');

        $user = $course->users()->where('user_id', '=', $userId)->first();

        if ( ! $user )
            return $this->responseError('Cannot find user.');

        $courseUsers->removeUserFromCourse($user, $course);

        return $this->responseSuccess($user);
    }

}