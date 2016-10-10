<?php

namespace Pi\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Pi\Auth\Permission;
use Pi\Auth\Role;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Courses\Course;
use Pi\Clients\Milestones\Milestone;
use Pi\Clients\Courses\Module;
use Pi\Clients\Courses\Article;
use Pi\DiscussionGroups\DiscussionGroup;
use Pi\Policies\ArticlePolicy;
use Pi\Policies\ClientPolicy;
use Pi\Policies\CoursePolicy;
use Pi\Policies\MilestonePolicy;
use Pi\Policies\ModulePolicy;
use Pi\Policies\UserPolicy;
use Pi\Policies\RolePolicy;
use Pi\Banners\Banner;
use Pi\Policies\BannerPolicy;
use Pi\Clients\Resources\Resource;
use Pi\Policies\ResourcePolicy;
use Pi\Clients\Courses\Quizzes\Quiz;
use Pi\Policies\QuizPolicy;
use Pi\Policies\DiscussionGroupPolicy;
use Pi\Clients\Locations\Buildings\Building;
use Pi\Clients\Locations\Rooms\Room;
use Clients\Pi\Locations\Rooms\RoomAttribute;
use Pi\Policies\BuildingPolicy;
use Pi\Policies\RoomPolicy;
use Pi\Policies\RoomAttributePolicy;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Banner::class => BannerPolicy::class,
        Building::class => BuildingPolicy::class,
        Client::class => ClientPolicy::class,
        Course::class => CoursePolicy::class,
        Milestone::class => MilestonePolicy::class,
        Module::class => ModulePolicy::class,
        Quiz::class => QuizPolicy::class,
        Resource::class => ResourcePolicy::class,
        Role::class => RolePolicy::class,
        Room::class => RoomPolicy::class,
        RoomAttribute::class => RoomAttributePolicy::class,
        User::class => UserPolicy::class,
        Milestone::class => MilestonePolicy::class,
        DiscussionGroup::class => DiscussionGroupPolicy::class

    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $isModerator = function (User $user) {
            return $user->isModerator();
        };

        $isAdmin = function (User $user) {
            return $user->isAdmin();
        };

        $isSuperAdmin = function (User $user) {
            return $user->isSuperAdmin();
        };

        $gate->define(Permission::USERS_MANAGE, $isSuperAdmin);
        $gate->define(Permission::MILESTONES_SHOW, $isModerator);

        $gate->define(Permission::INDUSTRIES_MANAGE, $isSuperAdmin);
        $gate->define(Permission::USERGROUPS_MANAGE, $isSuperAdmin);
        $gate->define(Permission::EVENTS_MANAGE, $isSuperAdmin);

        $gate->define(Permission::CLIENTS_MANAGE, $isSuperAdmin);
        $gate->define(Permission::CLIENT_USERGROUPS_MANAGE, function(User $user, Client $client){
            return $user->isSuperAdmin() || $user->isModerator($client);
        });

        $gate->define(Permission::DISCUSSION_GROUPS_MANAGE, $isModerator);
        $gate->define(Permission::THREAD_RAISE_HAND, $isModerator);

        $this->registerPolicies($gate);
    }
}
