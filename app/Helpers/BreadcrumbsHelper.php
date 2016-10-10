<?php

namespace Pi\Helpers;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Clients\Usergroups\ClientUsergroup;
use Pi\Services\BreadcrumbsService;

class BreadcrumbsHelper
{
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbs;

    public function __construct(BreadcrumbsService $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function add($url, $title)
    {
        $this->breadcrumbs->add($url, $title);
    }

    public function addTitle($title)
    {
        $this->breadcrumbs->add(\Request::url(), $title);
    }

    public function addClientLink(Client $client)
    {
        $this->breadcrumbs->add(route('clients.show', $client->slug), $client->name);
    }

    public function addManagementCourseLink(Course $course, Client $client = null)
    {
        if($client == null)
        {
            $client = $course->client;
        }

        $this->breadcrumbs->add(route('clients.manage.courses.index', [$client->slug]), 'Courses');
        $this->breadcrumbs->add(route('clients.manage.courses.edit', [$client->slug, $course->slug]), $course->name);
    }

    public function addManagementModuleLink(Module $module, Course $course = null, Client $client = null)
    {
        if($course == null)
        {
            $course = $module->course;
        }

        if($client == null)
        {
            $client = $course->client;
        }

        $this->breadcrumbs->add(route('clients.manage.courses.modules.edit', [$client->slug, $course->slug, $module->slug]), 'Module #' . $module->number);
    }

    public function addManagementArticleLink(Article $article, Module $module = null, Course $course = null, Client $client = null)
    {
        if($module == null)
        {
            $module = $article->module;
        }

        if($course == null)
        {
            $course = $module->course;
        }

        if($client == null)
        {
            $client = $course->client;
        }

        $this->breadcrumbs->add(route('clients.manage.courses.modules.articles.edit', [$client->slug, $course->slug, $module->slug, $article->id]), 'Article #' . $article->number);
    }
}