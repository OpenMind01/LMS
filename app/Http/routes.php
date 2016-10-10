<?php

/* ========================================================================
 *  Api Routes
 * ========================================================================
 */
Route::group([
    'prefix' => 'api',
    'middleware' => 'auth',
    'namespace' => 'Api',
], function() {
    Route::resource('snippets', 'SnippetsController');

    Route::post('clients/{id}/update', 'ClientsController@inlineUpdate');
    Route::post('clients/{id}/update_settings', 'ClientsController@updateSettings');
    Route::get('clients/{id}/courses', ['as' => 'api.client.courses', 'uses' => 'ClientsController@courses']);


    Route::resource('clients', 'ClientsController');

    # Raptor FileManager API
    Route::get('filemanager/{clientSlug}/{courseSlug}', 'FileManagerController@index');
    Route::post('filemanager/{clientSlug}/{courseSlug}', 'FileManagerController@index');
//    Route::get('c/{clientSlug}/courses/{courseSlug}/filemanager/test', 'FileManagerController@getTestView');

    # Modules
    Route::post('modules/{moduleId}/update-order', ['as' => 'modules.update-order', 'uses' => 'ModulesController@updateOrder']);
    Route::resource('modules', 'ModulesController');

    # Article Version Control
    Route::resource('articles/versions', 'ArticleVersionControlController');

    # Article Galleries
    Route::resource('articles.gallery', 'ArticleGalleryController');

    # Articles
    Route::post('articles/{id}/actions/mark-read', 'ArticlesController@markRead');

    Route::post('articles/{articleIdd}/actions/{actionId}/mark-complete', 'ArticleActionsController@markComplete');
    Route::post('articles/{articleIdd}/actions/{actionId}/mark-incomplete', 'ArticleActionsController@markIncomplete');
    Route::resource('articles.actions', 'ArticleActionsController');
    Route::post('articles/{id}/update', 'ArticlesController@inlineUpdate');
    Route::resource('articles', 'ArticlesController');
    Route::post('courses/{id}/update', 'CoursesController@inlineUpdate');
    Route::post('courses/{id}/users', 'CoursesController@addUser');
    Route::delete('courses/{id}/users/{userId}', 'CoursesController@removeUser');
    Route::resource('courses', 'CoursesController');

    Route::resource('quiz-elements', 'QuizElementsController');
    Route::resource('quiz-element-options', 'QuizElementOptionsController');

    Route::post('banners/dismiss', 'BannersController@dismiss');

    Route::get('calendar', ['as' => 'api.calendar', 'uses' => 'CalendarController@getIndex']);

    Route::resource('client.widget-settings', 'Client\WidgetSettingsController', [
        'only' => ['index', 'store']
    ]);
});

/* ========================================================================
 *  Registration Routes
 * ========================================================================
 */
Route::group([
    'prefix' => 'registration',
    'middleware' => 'auth:registration',
    'namespace' => 'Registration'
], function() {
    Route::controller('user', 'UserRegistrationController');
});

/* ========================================================================
 *  Authenticated Routes
 * ========================================================================
 */

Route::get('admin/users/unimpersonate', ['as' => 'admin.users.unimpersonate', 'uses' => 'Admin\UsersController@unimpersonate']);
Route::group(['middleware' => 'auth'], function() {

    Route::controller('change-password', 'Auth\ChangePasswordController');
    Route::controller('update-profile', 'Auth\UpdateProfileController');

    Route::group([
        'middleware' => 'auth:superadmin',
        'namespace' => 'Admin',
        'prefix' => 'admin',
    ], function() {
        Route::get('clients/{id}/usergroups', ['as' => 'admin.clients.usergroups', 'uses' => 'ClientsController@getUsergroups']);
        Route::post('clients/{id}/usergroups', ['as' => 'admin.clients.usergroups.post', 'uses' => 'ClientsController@postUsergroups']);
        Route::resource('clients', 'ClientsController');

        Route::get('users/{id}/impersonate', ['as' => 'admin.users.impersonate', 'uses' => 'UsersController@impersonate']);
        Route::post('users/{id}/attach-client', ['as' => 'admin.users.attach-client', 'uses' => 'UsersController@attachClient']);
        Route::post('users/{id}/detach-client', ['as' => 'admin.users.detach-client', 'uses' => 'UsersController@detachClient']);
        Route::post('users/{id}/attach-role', ['as' => 'admin.users.attach-role', 'uses' => 'UsersController@attachRole']);
        Route::post('users/{id}/detach-role', ['as' => 'admin.users.detach-role', 'uses' => 'UsersController@detachRole']);
        Route::resource('users', 'UsersController');

        Route::resource('industries', 'IndustriesController');
        Route::get('industries/{id}/clone', 'IndustriesController@getClone');
        Route::post('industries/{id}/clone', 'IndustriesController@postClone');

        Route::resource('usergroups', 'UsergroupsController');

        Route::resource('events', 'EventsController');
        Route::get('events/{id}/delete', 'EventsController@getDelete');
    });

    /* ========================================================================
     *  Client Routes
     * ========================================================================
     */
    Route::group([
        'middleware' => 'auth',
        'namespace' => 'Client',
//        'prefix' => 'c',
    ], function () {

        // Discussion routes
        // @TODO: Figure out a way to avoid repeating routes
        Route::group(['prefix' => 'c/{clientSlug}'], function() {

            /**
             * CLIENT LEVEL ROUTES
             */
            // Discussion Groups - List
            Route::get('discussion', ['as' => 'clients.discussions.index', 'uses' => 'DiscussionGroups\ClientDiscussionGroupsController@index']);

            // Discussion Groups - Create/Store
            Route::get('discussion/create', ['as' => 'clients.discussions.create', 'uses' => 'DiscussionGroups\ClientDiscussionGroupsController@create']);
            Route::post('discussion', ['as' => 'clients.discussions.store', 'uses' => 'DiscussionGroups\ClientDiscussionGroupsController@store']);

            // Discussion Groups - Show
            Route::get('discussion/{discussionGroupSlug}', ['as' => 'clients.discussions.show', 'uses' => 'DiscussionGroups\ClientDiscussionGroupsController@show']);

            // Thread - Show
            Route::get('discussion/{discussionGroupSlug}/{threadSlug}', ['as' => 'clients.discussions.threads.show', 'uses' => 'DiscussionGroups\Threads\ClientThreadController@show']);

            // Threads Create/Store
            Route::get('discussion/{discussionGroupSlug}/thread/create',
                ['as' => 'clients.discussions.threads.create', 'uses' => 'DiscussionGroups\Threads\ClientThreadController@create']);
            Route::post('discussion/{discussionGroupSlug}/threads',
                ['as' => 'clients.discussions.threads.store', 'uses' => 'DiscussionGroups\Threads\ClientThreadController@store']);

            // Threads Reply
            Route::post('discussion/{discussionGroupSlug}/thread/{threadSlug}/reply',
                ['as' => 'clients.discussions.threads.reply', 'uses' => 'DiscussionGroups\Threads\ClientThreadController@reply']);

            // Threads Raise Hand
            Route::get('discussion/{discussionGroupSlug}/thread/{threadSlug}/raise_hand',
                ['as' => 'clients.discussions.threads.raise_hand', 'uses' => 'DiscussionGroups\Threads\ClientThreadController@raiseHand']);

            /**
             * COURSE LEVEL ROUTES
             */
            // Discussion Groups - List
            Route::get('courses/{courseSlug}/discussion', ['as' => 'clients.courses.discussions.index', 'uses' => 'DiscussionGroups\CourseDiscussionGroupsController@index']);

            // Discussion Groups - Create/Store
            Route::get('courses/{courseSlug}/discussion/create', ['as' => 'clients.courses.discussions.create', 'uses' => 'DiscussionGroups\CourseDiscussionGroupsController@create']);
            Route::post('courses/{courseSlug}/discussion', ['as' => 'clients.courses.discussions.store', 'uses' => 'DiscussionGroups\CourseDiscussionGroupsController@store']);

            // Discussion Groups - Show
            Route::get('courses/{courseSlug}/discussion/{discussionGroupSlug}', ['as' => 'clients.courses.discussions.show', 'uses' => 'DiscussionGroups\CourseDiscussionGroupsController@show']);

            // Threads - Show
            Route::get('courses/{courseSlug}/discussion/{discussionGroupSlug}/{threadSlug}',
                ['as' => 'clients.courses.discussions.threads.show', 'uses' => 'DiscussionGroups\Threads\CourseThreadController@show']);

            // Threads - Create/Store
            Route::get('courses/{courseSlug}/discussion/{discussionGroupSlug}/thread/create',
                ['as' => 'clients.courses.discussions.threads.create', 'uses' => 'DiscussionGroups\Threads\CourseThreadController@create']);
            Route::post('courses/{courseSlug}/discussion/{discussionGroupSlug}/thread',
                ['as' => 'clients.courses.discussions.threads.store', 'uses' => 'DiscussionGroups\Threads\CourseThreadController@store']);

            // Threads Reply
            Route::post('courses/{courseSlug}/discussion/{discussionGroupSlug}/thread/{threadSlug}/reply',
                ['as' => 'clients.courses.discussions.threads.reply', 'uses' => 'DiscussionGroups\Threads\CourseThreadController@reply']);

            // Threads Raise Hand
            Route::get('courses/{courseSlug}/discussion/{discussionGroupSlug}/{threadSlug}/raise_hand',
                ['as' => 'clients.courses.discussions.threads.raise_hand', 'uses' => 'DiscussionGroups\Threads\CourseThreadController@raiseHand']);


            /**
             * MODULE LEVEL ROUTES
             */
            // Discussion Groups - List
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion', ['as' => 'clients.courses.modules.discussions.index', 'uses' => 'DiscussionGroups\ModuleDiscussionGroupsController@index']);

            // Discussion Groups - Create/Store
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion/create',
                ['as' => 'clients.courses.modules.discussions.create', 'uses' => 'DiscussionGroups\ModuleDiscussionGroupsController@create']);
            Route::post('courses/{courseSlug}/{moduleSlug}/discussion',
                ['as' => 'clients.courses.modules.discussions.store', 'uses' => 'DiscussionGroups\ModuleDiscussionGroupsController@store']);

            // Discussion Groups - Show
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}',
                ['as' => 'clients.courses.modules.discussions.show', 'uses' => 'DiscussionGroups\ModuleDiscussionGroupsController@show']);

            // Threads - Show
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}/{threadSlug}',
                ['as' => 'clients.courses.modules.discussions.threads.show', 'uses' => 'DiscussionGroups\Threads\ModuleThreadController@show']);

            // Threads - Create/Store
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}/thread/create',
                ['as' => 'clients.courses.modules.discussions.threads.create', 'uses' => 'DiscussionGroups\Threads\ModuleThreadController@create']);
            Route::post('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}/thread',
                ['as' => 'clients.courses.modules.discussions.threads.store', 'uses' => 'DiscussionGroups\Threads\ModuleThreadController@store']);

            // Threads Reply
            Route::post('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}/thread/{threadSlug}/reply',
                ['as' => 'clients.courses.modules.discussions.threads.reply', 'uses' => 'DiscussionGroups\Threads\ModuleThreadController@reply']);

            // Threads Raise Hand
            Route::get('courses/{courseSlug}/{moduleSlug}/discussion/{discussionGroupSlug}/{threadSlug}/raise_hand',
                ['as' => 'clients.courses.modules.discussions.threads.raise_hand', 'uses' => 'DiscussionGroups\Threads\ModuleThreadController@raiseHand']);

        });


        Route::resource('c', 'ClientsController', [
            'only' => ['show'],
            'names' => [
                'show' => 'clients.show'
            ]
        ]);

        Route::controller('c/{clientSlug}/activation', 'ActivationController');

        // Course Management
        Route::group([
            'prefix' => 'c/{clientSlug}/manage',
            'namespace' => 'Management'
        ], function() {

            Route::resource('buildings', 'Buildings\BuildingsController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.buildings.index',
                    'create' => 'clients.manage.buildings.create',
                    'edit' => 'clients.manage.buildings.edit',
                    'store' => 'clients.manage.buildings.store',
                    'update' => 'clients.manage.buildings.update',
                    'destroy' => 'clients.manage.buildings.destroy',
                ],
            ]);
            Route::delete('buildings/{id}/rooms/{roomId}/remove-user/{userId}', ['as' => 'clients.manage.buildings.rooms.remove-user', 'uses' => 'Buildings\RoomsController@removeUser']);
            Route::any('buildings/{id}/rooms/{roomId}/add-user/{userId}', ['as' => 'clients.manage.buildings.rooms.add-user', 'uses' => 'Buildings\RoomsController@addUser']);
            Route::resource('buildings/{id}/rooms', 'Buildings\RoomsController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.buildings.rooms.index',
                    'create' => 'clients.manage.buildings.rooms.create',
                    'edit' => 'clients.manage.buildings.rooms.edit',
                    'store' => 'clients.manage.buildings.rooms.store',
                    'update' => 'clients.manage.buildings.rooms.update',
                    'destroy' => 'clients.manage.buildings.rooms.destroy',
                ],
            ]);

            Route::resource('buildings/{id}/rooms/{roomId}/room-attributes', 'Buildings\RoomAttributesController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.buildings.rooms.attributes.index',
                    'create' => 'clients.manage.buildings.rooms.attributes.create',
                    'edit' => 'clients.manage.buildings.rooms.attributes.edit',
                    'store' => 'clients.manage.buildings.rooms.attributes.store',
                    'update' => 'clients.manage.buildings.rooms.attributes.update',
                    'destroy' => 'clients.manage.buildings.rooms.attributes.destroy',
                ],
            ]);

            Route::get('buildings/room-attributes/grid', 'Buildings\ClientRoomAttributesController@getGrid');
            Route::resource('buildings/room-attributes', 'Buildings\ClientRoomAttributesController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.buildings.room-attributes.index',
                    'create' => 'clients.manage.buildings.room-attributes.create',
                    'edit' => 'clients.manage.buildings.room-attributes.edit',
                    'store' => 'clients.manage.buildings.room-attributes.store',
                    'update' => 'clients.manage.buildings.room-attributes.update',
                    'destroy' => 'clients.manage.buildings.room-attributes.destroy',
                ],
            ]);

            Route::resource('banners', 'ClientBannerController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.banners.index',
                    'create' => 'clients.manage.banners.create',
                    'edit' => 'clients.manage.banners.edit',
                    'store' => 'clients.manage.banners.store',
                    'update' => 'clients.manage.banners.update',
                    'destroy' => 'clients.manage.banners.destroy',
                ],
            ]);

            Route::resource('resources', 'ClientResourceController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.resources.index',
                    'create' => 'clients.manage.resources.create',
                    'edit' => 'clients.manage.resources.edit',
                    'store' => 'clients.manage.resources.store',
                    'update' => 'clients.manage.resources.update',
                    'destroy' => 'clients.manage.resources.destroy',
                ],
            ]);

            Route::resource('milestones', 'MilestonesController', [
                'names' => [
                    'index' => 'clients.manage.milestones.index',
                    'create' => 'clients.manage.milestones.create',
                    'store' => 'clients.manage.milestones.store',
                    'edit' => 'clients.manage.milestones.edit',
                    'update' => 'clients.manage.milestones.update',
                    'destroy' => 'clients.manage.milestones.destroy',
                ],
            ]);

            Route::resource('events', 'ClientEventsController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.events.index',
                    'create' => 'clients.manage.events.create',
                    'edit' => 'clients.manage.events.edit',
                    'store' => 'clients.manage.events.store',
                    'update' => 'clients.manage.events.update',
                    'destroy' => 'clients.manage.events.destroy',
                ],
            ]);
            Route::get('events/{id}/delete', 'ClientEventsController@getDelete');

            Route::resource('industries', 'Usergroups\IndustriesController', [
                'only' => ['index', 'store'],
                'names' => [
                    'index' => 'clients.manage.industries.index',
                    'store' => 'clients.manage.industries.store',
                ],
            ]);

            Route::resource('usergroups', 'Usergroups\UsergroupsController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.usergroups.index',
                    'create' => 'clients.manage.usergroups.create',
                    'edit' => 'clients.manage.usergroups.edit',
                    'store' => 'clients.manage.usergroups.store',
                    'update' => 'clients.manage.usergroups.update',
                    'destroy' => 'clients.manage.usergroups.destroy',
                ],
            ]);

            Route::resource('usergroups/{id}/users', 'Usergroups\UsergroupUsersController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.usergroups.users.index',
                    'create' => 'clients.manage.usergroups.users.create',
                    'edit' => 'clients.manage.usergroups.users.edit',
                    'store' => 'clients.manage.usergroups.users.store',
                    'update' => 'clients.manage.usergroups.users.update',
                    'destroy' => 'clients.manage.usergroups.users.destroy',
                ],
            ]);

            Route::resource('theme', 'ClientThemeController', [
                'only' => ['index', 'store'],
                'names' => [
                    'index' => 'clients.manage.theme.index',
                    'store' => 'clients.manage.theme.store',
                ],
            ]);

            Route::resource('lesson-styles', 'ClientLessonStylesController', [
                'only' => ['index', 'store'],
                'names' => [
                    'index' => 'clients.manage.lesson-styles.index',
                    'store' => 'clients.manage.lesson-styles.store'
                ],
            ]);

            Route::controller('users-import', 'UsersImportController');



            Route::post('courses/{courseSlug}/users/{userId}/reset-progress', ['as' => 'clients.manage.courses.users.reset-progress', 'uses' => 'Courses\CourseUsersController@resetProgress']);
            Route::get('courses/{courseSlug}/users/{userId}/quizzes/{id}', ['as' => 'clients.manage.courses.users.quiz.show', 'uses' => 'Courses\CourseUsersController@showQuiz']);
            Route::resource('courses.users', 'Courses\CourseUsersController', [
                'only' => ['index', 'create', 'show', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.courses.users.index',
                    'create' => 'clients.manage.courses.users.create',
                    'show' => 'clients.manage.courses.users.show',
                ],
            ]);

            Route::get('courses/{courseSlug}/structure', ['as' => 'clients.manage.courses.structure', 'uses' => 'Courses\CourseController@getStructure']);
            Route::post('courses/{courseSlug}/module-order', ['as' => 'clients.manage.courses.module-order', 'uses' => 'Courses\CourseController@postModuleOrder']);
            Route::resource('courses', 'Courses\CourseController', [
                'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'index' => 'clients.manage.courses.index',
                    'create' => 'clients.manage.courses.create',
                    'edit' => 'clients.manage.courses.edit',
                    'store' => 'clients.manage.courses.store',
                    'update' => 'clients.manage.courses.update',
                    'destroy' => 'clients.manage.courses.destroy',
                ],
            ]);

            // Add routes for importing pages.
            Route::post('courses/{courseId}/import', 'Courses\CourseController@storeWithFile');
            Route::post('courses/{courseId}/import/saveItems', 'Courses\CourseController@saveModulesAndLessons');

            Route::get('courses/{slug}/clone', ['as' => 'clients.manage.courses.clone', 'uses' => 'Courses\CourseController@getClone']);
            Route::post('courses/{slug}/clone', 'Courses\CourseController@postClone');

            Route::get('courses/{slug}/create-usergroup', ['as' => 'clients.manage.courses.usergroup', 'uses' => 'Courses\CourseController@getCreateUsergroup']);
            Route::post('courses/{slug}/create-usergroup', 'Courses\CourseController@postCreateUsergroup');

            Route::post('courses/{courseId}/modules/{moduleId}/article-order', ['as' => 'clients.manage.courses.modules.article-order', 'uses' => 'Courses\ModuleController@postArticleOrder']);
            Route::resource('courses/{courseSlug}/modules', 'Courses\ModuleController', [
                'only' => ['create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'create' => 'clients.manage.courses.modules.create',
                    'edit' => 'clients.manage.courses.modules.edit',
                    'store' => 'clients.manage.courses.modules.store',
                    'update' => 'clients.manage.courses.modules.update',
                    'destroy' => 'clients.manage.courses.modules.destroy',
                ],
            ]);

            Route::resource('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/actions', 'Courses\ArticleActionsController', [
                'only' => ['create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'create' => 'clients.manage.courses.modules.articles.actions.create',
                    'edit' => 'clients.manage.courses.modules.articles.actions.edit',
                    'store' => 'clients.manage.courses.modules.articles.actions.store',
                    'update' => 'clients.manage.courses.modules.articles.actions.update',
                    'destroy' => 'clients.manage.courses.modules.articles.actions.destroy',
                ],
            ]);
            Route::resource('courses/{courseSlug}/modules/{moduleSlug}/articles', 'Courses\ArticleController', [
                'only' => ['create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'create' => 'clients.manage.courses.modules.articles.create',
                    'edit' => 'clients.manage.courses.modules.articles.edit',
                    'store' => 'clients.manage.courses.modules.articles.store',
                    'update' => 'clients.manage.courses.modules.articles.update',
                    'destroy' => 'clients.manage.courses.modules.articles.destroy',
                ],
            ]);

            Route::get('courses/articles/most-recent', [
                'as' => 'clients.manage.courses.modules.articles.most-recent',
                'uses' => 'Courses\ArticleController@mostRecent'
            ]);



            Route::post('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/quizzes/{quizId}/add-question', [
                'as' => 'clients.manage.courses.modules.articles.quizzes.add-question',
                'uses' => 'Courses\QuizController@addQuestion'
            ]);
            Route::post('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/quizzes/{quizId}/question-order', [
                'as' => 'clients.manage.courses.modules.articles.quizzes.question-order',
                'uses' => 'Courses\QuizController@postQuestionOrder'
            ]);
            Route::delete('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/quizzes/{quizId}/questions/{questionId}', [
                'as' => 'clients.manage.courses.modules.articles.quizzes.destroy-question',
                'uses' => 'Courses\QuizController@destroyQuestion'
            ]);
            Route::post('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/quizzes/{quizId}/questions/{questionId}', [
                'as' => 'clients.manage.courses.modules.articles.quizzes.update-question',
                'uses' => 'Courses\QuizController@updateQuestion'
            ]);

            Route::resource('courses/{courseSlug}/modules/{moduleSlug}/articles/{articleId}/quizzes', 'Courses\QuizController', [
                'only' => ['create', 'edit', 'store', 'update', 'destroy'],
                'names' => [
                    'create' => 'clients.manage.courses.modules.articles.quizzes.create',
                    'edit' => 'clients.manage.courses.modules.articles.quizzes.edit',
                    'store' => 'clients.manage.courses.modules.articles.quizzes.store',
                    'update' => 'clients.manage.courses.modules.articles.quizzes.update',
                    'destroy' => 'clients.manage.courses.modules.articles.quizzes.destroy',
                ],
            ]);
        });
        // End Course Management

        Route::resource('c/{clientSlug}/courses', 'CourseController', [
            'only' => ['create', 'show'],
            'names' => [
                'create' => 'clients.courses.create',
                'show' => 'clients.courses.show',
            ],
        ]);

        Route::get('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}', ['as' => 'clients.courses.modules.show', 'uses' => 'ModuleController@show']);
        Route::get('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/edit', ['as' => 'clients.courses.modules.edit', 'uses' => 'ModuleController@edit']);
        Route::post('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/upload-word-file', ['as' => 'clients.courses.modules.wordfile', 'uses' => 'ModuleController@uploadWordFile']);

        Route::get('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleNumber}', ['as' => 'clients.courses.modules.articles.show', 'uses' => 'ArticleController@show']);
        Route::get('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleNumber}/edit', ['as' => 'clients.courses.modules.articles.edit', 'uses' => 'ArticleController@edit']);
        Route::put('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleNumber}/edit', ['as' => 'clients.courses.modules.articles.update', 'uses' => 'ArticleController@update']);
        Route::get('c/{clientSlug}/courses/{courseSlug}/modules/{moduleSlug}/articles/{articleNumber}/quizzes/{quizId}/attempts/{attemptId}', ['as' => 'clients.courses.modules.articles.quizzes.attempts.show', 'uses' => 'QuizController@showQuizAttempt']);
        Route::post('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleNumber}/quiz/{quizId}', ['as' => 'clients.courses.modules.articles.quizzes.update', 'uses' => 'QuizController@update']);
        Route::get('c/{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleNumber}/quiz/{quizId}', ['as' => 'clients.courses.modules.articles.quizzes.show', 'uses' => 'QuizController@show']);

//        Route::resource('{clientSlug}/courses/{courseSlug}/', 'ModuleController', [
//            'only' => ['create', 'show'],
//            'names' => [
//                'create' => 'clients.courses.modules.create',
//                'show' => 'clients.courses.modules.show'
//            ],
//        ]);
//
//        Route::resource('{clientSlug}/courses/{courseSlug}/{moduleSlug}/{articleSlug}', 'ArticleController', [
//            'only' => ['create', 'show'],
//            'names' => [
//                'create' => 'clients.courses.modules.articles.create',
//                'show' => 'clients.courses.modules.articles.show'
//            ],
//        ]);

        Route::controller('c/{clientSlug}/meeting', 'ScheduleMeetingController');
    });

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('dashboard/google-token', ['as' => 'dashboard.googleToken', 'uses' => 'DashboardController@setGoogleToken']);

});

Route::group(['prefix' => 'temp'], function() {
    Route::controller('/', 'TempController');
});
Route::get('test/word', 'TempController@getTestWordImporting');

// TEMP: Temporary route for test the internal link feature.
Route::get('test/articles/{clientSlug}/{courseSlug}/{moduleSlug}', 'TempController@getArticles');

/* ========================================================================
 *  Front End (Auth) Routes
 * ========================================================================
 */

// Authentication routes...
Route::get('login', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'auth.login']);
Route::post('login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'auth.doLogin']);
Route::get('logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/css/theme/{themeId}/{updateAt}', 'ThemeCssController@getIndex');

// Email Parsing Routes...
Route::any('email/incoming/parse', 'EmailParsingController@parse');

// Email Parsing Routes...
Route::post('email/incoming/parse', 'EmailParsingController@parse');

Route::post('/raptor-stub', function() {
    $content = json_decode(Input::get('raptor-content'));
    return response()->json(['success' => true, 'content' => $content]);
});

Route::get('/', function() {
    return redirect()->route('auth.login');
});

/* ========================================================================
 *  UI Test Route - Please edit this as required
 * ========================================================================
 */

Route::get('/ui-test', function() {
    return view('themes.ui-test');
});

Route::get('/ui-reading-test', function() {
    return view('themes.ui-reading-test');
});
