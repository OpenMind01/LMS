<?php

namespace Pi\Clients\Usergroups;

use Pi\Clients\Client;
use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Module;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Usergroups\Usergroup;
use Pi\Usergroups\UsergroupArticle;
use Pi\Usergroups\UsergroupModule;
use Pi\Usergroups\UsergroupsService;

class ClientUsergroupCreator
{
    /**
     * @var ArticlesService
     */
    private $articlesService;

    /**
     * @var UsergroupsService
     */
    private $usergroupsService;

    public function __construct(ArticlesService $articlesService, UsergroupsService $usergroupsService)
    {
        $this->articlesService = $articlesService;
        $this->usergroupsService = $usergroupsService;
    }

    /**
     * @param Client $client
     * @param $usergroupId
     * @return ClientUsergroup
     * @throws EntityNotFoundException
     */
    public function create(Client $client, $usergroupId)
    {
        if($client->usergroups->contains($usergroupId))
        {
            return $client->innerUsergroups->first(function($k, ClientUsergroup $clientUsergroup) use($usergroupId){
                return $clientUsergroup->usergroup_id == $usergroupId;
            });
        }

        $usergroup = $this->usergroupsService->getOpen($usergroupId);

        $clientUserGroup = new ClientUsergroup();
        $clientUserGroup->client_id = $client->id;
        $clientUserGroup->usergroup_id = $usergroup->id;

        $course = $this->createCourse($usergroup, $client);

        $clientUserGroup->course_id = $course->id;

        $clientUserGroup->save();

        return $clientUserGroup;
    }

    private function createCourse(Usergroup $usergroup, Client $client)
    {
        $course = new Course();
        $course->client_id = $client->id;
        $course->name = 'User group: ' . $usergroup->title;
        $course->description = $usergroup->course->description;
        $course->type = Course::TYPE_USERGROUP;

        $course->save();

        foreach($usergroup->course->modules as $module)
        {
            /**
             * @var UsergroupModule $usergroupModule
             */
            $usergroupModule = $usergroup->modules->first(function($k, UsergroupModule $uModule) use ($module){
                return $uModule->module_id == $module->id;
            });

            if($usergroupModule != null)
            {
                $newModule = new Module();
                $newModule->client_id = $course->client_id;
                $newModule->course_id = $course->id;
                $newModule->name = $module->name;
                $newModule->number = $module->number;
                $newModule->save();

                foreach($module->articles as $article)
                {
                    if($usergroupModule->articles->contains(function($k, UsergroupArticle $uModule) use ($article){
                        return $uModule->article_id == $article->id;
                    }))
                    {
                        $this->articlesService->cloneArticle($article, $newModule);
                    }
                }
            }
        }

        return $course;
    }
}