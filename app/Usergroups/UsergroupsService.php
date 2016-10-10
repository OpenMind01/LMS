<?php

namespace Pi\Usergroups;

use Pi\Clients\Client;
use Pi\Clients\Courses\Services\ArticlesService;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Services\CoursesService;
use Pi\Clients\Courses\Module;
use Pi\Constants;
use Pi\Domain\Requests\Usergroups\IUsergroupCreateRequest;
use Pi\Exceptions\EntityNotFoundException;
use Pi\Exceptions\Usergroups\ArticleOfUnusedModuleUsedException;
use Pi\Exceptions\Usergroups\InvalidArticleException;
use Pi\Exceptions\Usergroups\InvalidModuleException;
use Pi\Exceptions\Usergroups\UsergroupCannotBeReadyException;
use Pi\Exceptions\NotAllowedException;
use Pi\Http\Requests\Usergroups\UsergroupCreateRequest;
use Pi\Http\Requests\Usergroups\UsergroupUpdateRequest;

class UsergroupsService
{
    /**
     * @var CoursesService
     */
    private $coursesService;

    /**
     * @var ArticlesService
     */
    private $articlesService;

    public function __construct(CoursesService $coursesService, ArticlesService $articlesService)
    {
        $this->coursesService = $coursesService;
        $this->articlesService = $articlesService;
    }

    /**
     * @param int $id
     * @return Usergroup
     */
    public function get($id)
    {
        return Usergroup::findOrFail($id);
    }

    /**
     * @param int $id
     * @return Usergroup
     * @throws EntityNotFoundException
     */
    public function getOpen($id)
    {
        /**
         * @var Usergroup $usergroup
         */
        $usergroup = Usergroup::findOrFail($id);

        if(!$usergroup->ready)
        {
            throw new EntityNotFoundException(Usergroup::class, 'open id', $id);
        }

        return $usergroup;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Usergroup::orderBy('title');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryOpen()
    {
        return Usergroup::whereReady(true)->orderBy('title');
    }

    /**
     * @return Course[]
     */
    public function getAllowedCourses()
    {
        return Course::whereClientId(Constants::getUsergroupClientId())->get()->getDictionary();
    }

    /**
     * @return Client
     */
    public function getUsergroupsClient()
    {
        return Client::findOrFail(Constants::getUsergroupClientId());
    }

    /**
     * @param IUsergroupCreateRequest $request
     * @return Usergroup
     * @throws NotAllowedException
     */
    public function create(IUsergroupCreateRequest $request)
    {
        $allowedCourses = $this->getAllowedCourses();

        if(!array_key_exists($request->getCourseId(), $allowedCourses))
        {
            throw new NotAllowedException('Course is not allowed');
        }

        $usergroup = new Usergroup();
        $usergroup->course_id = $request->getCourseId();
        $usergroup->title = $request->getTitle();
        $usergroup->ready = false;

        $usergroup->save();

        return $usergroup;
    }

    public function update(Usergroup $usergroup, UsergroupUpdateRequest $request)
    {
        $modules = $request->getModules();
        $articles = $request->getArticles();

        if(empty($modules) && empty($articles) && $request->getReady())
        {
            throw new UsergroupCannotBeReadyException();
        }

        $this->syncModulesAndArticles($usergroup, $modules, $articles);

        $usergroup->title = $request->getTitle();
        $usergroup->ready = $request->getReady();
        $usergroup->industries()->sync($request->getIndustries());

        $usergroup->save();
    }

    /**
     * Returns ready user groups which exists in specified industries
     *
     * @param int[] $industries
     * @return \Illuminate\Database\Eloquent\Collection|Usergroup[]
     */
    public function getOpenUsergroups($industries)
    {
        return Usergroup::whereReady(true)->whereHas('industries', function ($query) use ($industries) {
            $query->whereIn('id', $industries);
        })->get();
    }

    /**
     * @param Usergroup $usergroup
     * @return Module[]
     */
    public function getPossibleModules(Usergroup $usergroup)
    {
        return Module::whereCourseId($usergroup->course_id)->with('articles')->get()->getDictionary();
    }

    /**
     * @param Usergroup $usergroup
     * @return UsergroupModule[]
     */
    public function getUsergroupModules(Usergroup $usergroup)
    {
        return $usergroup->modules()->with('articles')->get();
    }

    /**
     * @param Usergroup $usergroup
     * @param int[] $modules
     * @param int[] $articles
     * @throws ArticleOfUnusedModuleUsedException
     * @throws InvalidArticleException
     * @throws InvalidModuleException
     */
    private function syncModulesAndArticles(Usergroup $usergroup, array $modules, array $articles)
    {
        $possibleModules = $this->getPossibleModules($usergroup);
        $articlesToModule = [];
        foreach($possibleModules as $module)
        {
            foreach($module->articles as $usergroupArticle)
            {
                $articlesToModule[$usergroupArticle->id] = $module->id;
            }
        }

        // Validation
        foreach($modules as $moduleId)
        {
            if(!isset($possibleModules[$moduleId]))
            {
                throw new InvalidModuleException();
            }
        }

        foreach($articles as $articleId)
        {
            if(!isset($articlesToModule[$articleId]))
            {
                throw new InvalidArticleException();
            }

            if(array_search($articlesToModule[$articleId], $modules) === false)
            {
                throw new ArticleOfUnusedModuleUsedException();
            }
        }

        // Processing
        /**
         * @var UsergroupModule[] $currentUsergroupModules
         */
        $currentUsergroupModules = $usergroup->modules()->with('articles')->get();

        $currentModules = [];
        $moduleToUsergroupModule = [];
        foreach($currentUsergroupModules as $currentUsergroupModule)
        {
            $currentModules[$currentUsergroupModule->module_id] = [];
            $moduleToUsergroupModule[$currentUsergroupModule->module_id] = $currentUsergroupModule;
            foreach($currentUsergroupModule->articles as $usergroupArticle)
            {
                $currentModules[$currentUsergroupModule->module_id][$usergroupArticle->article_id] = $usergroupArticle->article_id;
            }
        }

        // Deleting unused modules and articles
        foreach($currentUsergroupModules as $usergroupModule)
        {
            if(array_search($usergroupModule->module_id, $modules) === false) {
                $usergroupModule->delete();
                continue;
            }

            foreach($usergroupModule->articles as $usergroupArticle)
            {
                if(array_search($usergroupArticle->article_id, $articles) === false) {
                    $usergroupArticle->delete();
                }
            }
        }

        // Inserting modules and articles
        foreach($modules as $moduleId)
        {
            if(!isset($currentModules[$moduleId]))
            {
                $usergroupModule = new UsergroupModule();
                $usergroupModule->module_id = $moduleId;
                $usergroupModule->usergroup_id = $usergroup->id;

                $usergroupModule->save();
            }
            else
            {
                $usergroupModule = $moduleToUsergroupModule[$moduleId];
            }

            foreach($possibleModules[$moduleId]->articles as $article)
            {
                if(array_search($article->id, $articles) !== false && !isset($currentModules[$moduleId][$article->id]))
                {
                    $usergroupArticle = new UsergroupArticle();
                    $usergroupArticle->article_id = $article->id;

                    $usergroupModule->articles()->save($usergroupArticle);
                }
            }
        }
    }
}