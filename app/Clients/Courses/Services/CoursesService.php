<?php

namespace Pi\Clients\Courses\Services;

use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Http\Requests\Clients\Courses\CourseCloneRequest;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Clients\Courses\Article;

class CoursesService
{
    /**
     * @var ArticlesService
     */
    private $articlesService;

    public function __construct(ArticlesService $articlesService)
    {
        $this->articlesService = $articlesService;
    }

    /**
     * @param $id
     * @return Course
     */
    public function get($id)
    {
        return Course::findOrFail($id);
    }

    /**
     * Gets the course by slug and client
     *
     * @param Client $client
     * @param $slug
     * @return Course
     * @throws EntityNotFoundException
     */
    public function getBySlug(Client $client, $slug)
    {
        /** @var Course $course */
        $course = Course::whereClientId($client->id)->whereSlug($slug)->first();

        if(!$course)
        {
            throw new EntityNotFoundException(self::class, 'id in client', $slug . ' ' . $client->id);
        }

        return $course;
    }

    /**
     * Returns course article, ordered by modules and numbers
     *
     * @param Course $course
     * @return Article[]
     */
    public function getCourseArticles(Course $course)
    {
        $articles = [];
        foreach($course->modules()->with('articles')->get() as $module)
        {
            foreach($module->articles as $article)
            {
                $articles[] = $article;
            }
        }

        return $articles;
    }

    /**
     * @param Course $course
     * @returns int
     */
    public function getCourseComplexity(Course $course)
    {
        $sum = 0;

        foreach($this->getCourseArticles($course) as $article)
        {
            $sum += $this->getArticleComplexity($article);
        }

        return $sum;
    }

    /**
     * @param Article $article
     * @return int
     */
    public function getArticleComplexity(Article $article)
    {
        // In future we can count pages for more accurate progress calculating
        return 1;
    }

    /**
     * Clones course to specified client(can be the same as courses client)
     * @param Course $course
     * @param Client $client
     * @param CourseCloneRequest $request
     * @return Course
     */
    public function cloneCourse(Course $course, Client $client, CourseCloneRequest $request)
    {
        $newCourse = new Course();
        $newCourse->client_id = $client->id;
        $newCourse->name = $request->getName();
        $newCourse->description = $course->description;
        $newCourse->type = Course::TYPE_CLIENT;

        $newCourse->save();

        foreach($course->modules as $module)
        {
            $newModule = new Module();
            $newModule->client_id = $newCourse->client_id;
            $newModule->course_id = $newCourse->id;
            $newModule->name = $module->name;
            $newModule->number = $module->number;
            $newModule->save();

            foreach($module->articles as $article)
            {
                $this->articlesService->cloneArticle($article, $newModule);
            }
        }

        return $newCourse;
    }

    public function userBelongsToCourse(User $user, Course $course) {
            return (bool) ($course->users->where('id', $user->id)->count());
    }
}