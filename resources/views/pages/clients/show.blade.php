@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li class="active">{{ $client->name }}</li>
@stop
@section('content')
    <div class="show-client">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-bg-cover">
                        @if($client->theme->hasBackground())
                            <img class="img-responsive"
                                 src="{{$client->theme->background->url()}}"
                                 alt="Logo" style="transform: translateY({{ $currentUser->client->theme->background_offset }}%);"/>
                        @else
                            <img class="img-responsive"
                                 src="/assets/img/thumbs/img1.jpg" alt="Logo"/>
                        @endif
                    </div>
                    <div class="panel-media">
                        @if($client->theme->hasLogo())
                            <img src="{{$client->theme->logo->url('medium')}}"
                                 class="panel-media-img img-circle img-border-light"
                                 alt="Logo">
                        @else
                            <img src="/assets/img/av1.png"
                                 class="panel-media-img img-circle img-border-light"
                                 alt="Profile Picture">
                        @endif
                        <div class="row">
                            <div class="col-lg-7">
                                <h3 class="panel-media-heading">{{ $client->name }}</h3>
                            </div>
                            <div class="col-lg-5 text-lg-right">
                                {{--<button class="btn btn-sm btn-primary">Add Friend</button>--}}
                                <button class="btn btn-sm btn-mint btn-icon fa fa-envelope icon-lg"></button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="inline-editable" data-id="description">
                            {!! $client->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @include('partials.banners.list')
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">

                <!--Default Tabs (Left Aligned)-->
                <!--===================================================-->
                <div class="tab-base">

                    <!--Nav Tabs-->
                    <ul class="nav nav-tabs">
                        @foreach($client->courses as $key => $course)
                            <li class="{{$key == 0 ? 'active' : ''}}">
                                <a href="#demo-lft-tab-{{$key}}"
                                   data-toggle="tab"
                                   aria-expanded="{{$key == 0 ? 'false' : 'true'}}">{{$course->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                    <!--Tabs Content-->
                    <div class="tab-content">
                        @foreach($client->courses as $count => $course)
                            <div class="tab-pane fade {{$count == 0 ? 'active in':''}}"
                                 id="demo-lft-tab-{{$count}}">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Users</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-dt-basic_wrapper"
                                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table width="100%"
                                                           cellspacing="0"
                                                           class="table table-striped table-bordered dataTable no-footer dtr-inline"
                                                           id="demo-dt-basic"
                                                           role="grid"
                                                           aria-describedby="demo-dt-basic_info"
                                                           style="width: 100%;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 264px;"
                                                                aria-sort="ascending"
                                                                aria-label="Name: activate to sort column descending">
                                                                Name
                                                            </th>
                                                            <th class="sorting"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 419px;"
                                                                aria-label="Current Article: Activate to sort column ascending">
                                                                Current Article
                                                            </th>
                                                            <th class="min-tablet sorting"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 193px;"
                                                                aria-label="Progress: Activate to sort column ascending">
                                                                Module Progress
                                                            </th>
                                                            <th class="min-tablet sorting"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 129px;"
                                                                aria-label="Last Login: activate to sort column ascending">
                                                                Last Login
                                                            </th>
                                                            <th class="min-tablet sorting"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 129px;"
                                                                aria-label="Last Login: activate to sort column ascending">
                                                                Last Logout
                                                            </th>
                                                            <th class="min-desktop sorting"
                                                                tabindex="0"
                                                                aria-controls="demo-dt-basic"
                                                                rowspan="1"
                                                                colspan="1"
                                                                style="width: 203px;"
                                                                aria-label="Login Status: activate to sort column ascending">
                                                                Login Status
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($course->users as $user)
                                                            <?php $courseUser = \Pi\Clients\Courses\CourseUser::whereCourseId($course->id)
                                                                    ->whereUserId($user->id)
                                                                    ->first();?>
                                                            <tr role="row">
                                                                <td>{{$user->name}}</td>
                                                                <td>{{$courseUser->getCurrentArticleId()}}</td>
                                                                <td>{{$courseUser->progress_percent}}
                                                                    %
                                                                </td>
                                                                <td>{{$user->last_login}}</td>
                                                                <td>{{$user->last_logout}}</td>
                                                                <td>{{$user->login_status == 'true' ? 'logged in' : 'logged out'}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Line Chart</h3>
                    </div>
                    <div class="panel-body">
                        <div style="height: 212px; padding: 0px; position: relative;"
                             id="demo-flot-line"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-6">
                @if($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isModerator())
                    <div class="panel manage-clients-block" >
                        <div class="panel-heading">
                            <h3 class="panel-title">Manage Client</h3>
                        </div>
                        <div class="panel-body">
                            @can('manage', [(new Pi\Banners\Banner), $client])
                            <a href="{{ route('clients.manage.banners.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage Banners</a>
                            @endcan

                            @can('manage', [(new Pi\Clients\Resources\Resource), $client])
                            <a href="{{ route('clients.manage.resources.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage Resources</a>
                            @endcan

                            @can('manage', [(new Pi\Clients\Courses\Course)])
                            <a href="{{ route('clients.manage.courses.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage Courses</a>
                            @endcan

                            @can('manage', $client)
                            <hr>
                            <a href="{{ route('clients.manage.usergroups.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage User groups</a>

                            <a href="{{ route('clients.manage.industries.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Industries</a>

                            <a href="{{ action('Client\Management\UsersImportController@getIndex', $client->slug) }}"
                               class="btn btn-info">Import users</a>
                            @endcan
                            @can('manageMilestones', $client)
                            <a href="{{ route('clients.manage.milestones.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage milestones</a>
                            @endcan

                            @can('manageEvents', $client)
                            <a href="{{ route('clients.manage.events.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage Events</a>
                            @endcan
                            @can('manage', $client)
                            <a href="{{ route('clients.manage.theme.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Theme</a>

                            <a href="{{ route('clients.manage.lesson-styles.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Lesson Styles</a>

                            <a href="{{ route('clients.manage.buildings.index', ['clientSlug' => $client->slug]) }}"
                               class="btn btn-info">Manage Buildings</a>
                            @endcan

                            @can('scheduleMeeting', $client)
                            <hr>

                            <a href="{{ action('Client\ScheduleMeetingController@getIndex', [$client->slug]) }}"
                               class="btn btn-info">Arrange a meeting with
                                administrator</a>
                            @endcan
                        </div>
                    </div>
                @endif
                <div class="panel">
                    <div class="panel-heading">

                        <h3 class="panel-title">Resources
                            for {{ $client->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Link</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client->resources as $resource)
                                <tr>
                                    <td>{{ $resource->name }}</td>
                                    <td>
                                        <a href="{{ $resource->url }}"
                                           target="_blank">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 courses">
                @foreach($client->courses as $course)
                    <?php
                    $courseUser = \Pi\Clients\Courses\CourseUser::whereCourseId($course->id)
                            ->whereUserId(\Auth::user()->id)
                            ->first();
                    ?>
                    @if($courseUser)
                        <div class="panel" id="demo-panel-w-alert">

                            <!--Panel heading-->
                            <div class="panel-heading">
                                <div class="panel-control">
                                    <i class="fa {{$courseUser->completion_icon}} fa-lg fa-fw"></i>
                                    <span class="badge badge-pink">{{$courseUser->completion_date}}</span>
                                    @if(!$courseUser->isComplete())
                                        <span class="label label-purple"> {{$courseUser->progress_percent}}
                                            %</span>
                                    @endif
                                </div>
                                <h3 class="panel-title">{{ $course->name }}</h3>
                            </div>

                            <!--Panel body-->
                            @if(!$courseUser->isComplete())
                                <div class="panel-body">

                                    <div class="col-xs-12 small">
                                        {!! $course->description !!}
                                    </div>
                                    <div class="col-xs-12">
                                        <a class='enter-course-button btn btn-warning'
                                           href="{{ route('clients.courses.show', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug]) }}">
                                            Enter {{ $course->name }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="panel" id="demo-panel-w-alert">

                            <!--Panel heading-->
                            <div class="panel-heading">
                                <div class="panel-control">
                                    <i class="fa fa-exclamation fa-lg fa-fw"></i>
                                    <span class="badge badge-pink"></span>
                                    <span class="label label-purple">Incomplete</span>
                                </div>
                                <h3 class="panel-title">{{ $course->name }}</h3>
                            </div>

                            <!--Panel body-->
                            <div class="panel-body">
                                <div class="col-xs-12 small">
                                    {!! $course->description !!}
                                </div>
                                <div class="col-xs-12">
                                    <a class='enter-course-button btn btn-warning'
                                       href="{{ route('clients.courses.show', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug]) }}">
                                        Enter {{ $course->name }}</a>
                                </div>
                            </div>
                        </div>

                    @endif
                @endforeach
            </div>
        </div>
    </div>

@stop

@section('inline-scripts')

    <script type="text/javascript"
            src="/assets/js/app/widgets/progress-chart.flot.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/flot-charts/jquery.flot.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/flot-charts/jquery.flot.time.js"></script>
    <script src="/assets/plugins/raptor-editor/raptor.js"></script>


{{--  --}}
    {{--Init The Progress Chart--}}
    <script type="text/javascript">
        $(function () {
            var Series = function () {
                this.options = [];

                this.data = [
                    {
                        'label': '2011-10-10',
                        'students': 1,
                        'completed': 1
                    },
                    {
                        'label': '2011-10-11',
                        'students': 2,
                        'completed': 1
                    },
                    {
                        'label': '2011-10-12',
                        'students': 2,
                        'completed': 1
                    },
                    {
                        'label': '2011-10-13',
                        'students': 2,
                        'completed': 1
                    },
                    {
                        'label': '2011-10-14',
                        'students': 2,
                        'completed': 1
                    },
                    {
                        'label': '2011-10-15',
                        'students': 2,
                        'completed': 1
                    }

                ];

            };


            var progressChart = new ProgressChart($('#demo-flot-line'), new Series());


        });
    </script>



    @can('manage', $client)
    <script>
        (function ($) {
            // Add Raptor editing functions here, or extract to a js file
            $(".inline-editable").raptor({
                plugins: {
                    // Define which save plugin to use. May be saveJson or saveRest
                    save: {
                        plugin: 'saveJson'
                    },
                    // Provide options for the saveJson plugin
                    saveJson: {
                        // The URL to which Raptor data will be POSTed
                        url: '/api/clients/{{ $client->id }}/update',
                        // The parameter name for the posted data
                        postName: 'raptor-content',

                        post: function (data) {
                            data._token = '{{ csrf_token() }}';
                            return data;
                        },
                        // A string or function that returns the identifier for the Raptor instance being saved
                        id: function () {
                            return this.raptor.getElement().data('id');
                        }
                    }
                }
            });
        })(jQuery);
    </script>
    @endcan
@stop