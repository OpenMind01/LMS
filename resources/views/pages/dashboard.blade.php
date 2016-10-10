@extends('layouts.default')

{{--
@if($currentUser->isAdmin())
@section('containerClasses', 'aside-in aside-right aside-bright  aside-fixed aside-hidden')
@endif
--}}

@section('page-title')
    Dashboard
@stop

@section('content')

    @if (session('refresh_token_error'))
        <div class='row'>
            <div class="col-sm-12">
                <div class="alert alert-block alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <div>
                        Could you please delete our application
                        <a href="https://security.google.com/settings/security/permissions"
                           target="_blank">
                            from here
                        </a>
                        and try again.
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (isset($askForToken) && $askForToken)
        <div class='row'>
            <div class="col-sm-12">
                <div class="alert alert-block alert-warning">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <i class="ace-icon fa fa-exclamation-sign orange"></i>

                    <h3>Google calendar access</h3>
                    <hr/>
                    We don't have access to your Google calendar and your client
                    can't arrange meeting with you. <a href="{{ $authUrl }}">Click
                        here</a> to set it up.
                </div>
            </div>
        </div>
    @endif

    <div class="panel">
        <div class="panel-bg-cover">
            @if($currentUser->client->theme->hasBackground())
                <img class="img-responsive"
                     src="{{$currentUser->client->theme->background->url()}}" style="transform: translateY({{ $currentUser->client->theme->background_offset }}%);"
                     alt="Logo"/>
            @else
                <img class="img-responsive" src="/assets/img/default-banner.png"
                     alt="Logo"/>
            @endif
        </div>
        <div class="panel-media">

            @if($currentUser->client->theme->hasLogo())
                <img src="{{$currentUser->client->theme->logo->url('medium')}}"
                     class="panel-media-img img-circle img-border-light"
                     alt="Logo">
            @else
                <img src="/assets/img/av1.png"
                     class="panel-media-img img-circle img-border-light"
                     alt="Profile Picture">
            @endif
            <div class="row">
                <div class="col-lg-7">
                    <h3 class="panel-media-heading">{{\Auth::user()->name}}</h3>
                </div>
                @if($currentUser->isAdmin())
                    <div class="col-lg-5 text-lg-right">
                        <button class="btn btn-md btn-primary">Edit profile
                        </button>
                        <button id="aside-toggle"
                                class="btn btn-md btn-warning">Edit dashboard
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Course progress</h4>
                    <p>You are taking course <a href="#" class="text-primary">Course
                            name</a>. You are currently in the lesson <a
                                href="#" class="text-primary">Lesson name</a>,
                        part of the <a href="#" class="text-primary">Module
                            name</a> module.</p>
                    <p>
                        <a href="{{URL::route('clients.manage.courses.modules.articles.most-recent',\Auth::user()->client->id)}}">
                            <button class="btn btn-md btn-primary" id="continue-class">Continue the
                                class
                            </button>
                        </a>
                    </p>
                </div>
                <div class="col-sm-6">
                    <h4>Course statistics</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Active course progress</h5>
                            <div class="progress progress-sm">
                                <div style="width: 95%;"
                                     class="progress-bar progress-bar-mint"></div>
                            </div>
                            <small class="help-block">You have completed
                                <b>95%</b> of this course. You have still <b>1
                                    module</b> to do.
                            </small>
                        </div>
                        <div class="col-sm-6">
                            <h5>Active module progress</h5>
                            <div class="progress progress-sm">
                                <div style="width: 10%;"
                                     class="progress-bar progress-bar-mint"></div>
                            </div>
                            <small class="help-block">You have completed
                                <b>10%</b> of this module. You have still <b>6
                                    lessons</b> to do.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $client = \Auth::user()->client;?>
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
                           class="btn btn-info">Milestones</a>
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

        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-heading">

                    <h3 class="panel-title">Resources
                        for {{ $client->name }}</h3>
                </div>
                <div class="panel-body">
                    @if($client->resources->count())
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
                    @else
                        There are no resources.
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 dropzone-container">
            <div id="drop_2" class="dropzone">
                @if($currentUser->isModerator())
                    @include('widgets.students-completion-progress')
                @endif
            </div>
        </div>
        <div class="col-sm-4 dropzone-container">
            <div id="drop_3" class="dropzone">
                @include('widgets.calendar')
            </div>
        </div>
    </div>
@stop

@if($currentUser->isAdmin())
@section('aside')
    @include('partials.asides.dashboard')
@stop
@endif

@section('inline-scripts')

    {{--Progress Chart--}}
{{--    <script type="text/javascript"
            src="/assets/js/app/widgets/progress-chart.flot.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/flot-charts/jquery.flot.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/flot-charts/jquery.flot.time.js"></script>
    <script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script> --}}

    <script src="/js/dashboard.js"></script>
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

    <link href="/assets/plugins/fullcalendar/fullcalendar.min.css"
          rel="stylesheet">
    {{--<script src="/assets/plugins/fullcalendar/lib/moment.min.js"></script>
    <script src="/assets/plugins/fullcalendar/fullcalendar.min.js"></script>

    <script src="/assets/plugins/fullcalendar/gcal.js"></script>
    <script src="/assets/plugins/jquery-sortable/jquery-ui.min.js"></script>
    <script src="/assets/plugins/skycons/skycons.min.js"></script>
    <!--Morris.js [ OPTIONAL ]-->
    <script src="plugins/morris-js/morris.min.js"></script>
    <script src="plugins/morris-js/raphael-js/raphael.min.js"></script>--}}
    <script>
        var dashboard_events = $('#user_calendar').fullCalendar({
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: '/api/calendar',
            loading: function (bool) {
                if (bool === false) {
                    render_calendar_events();
                }
            }
        });

        var event_list;

        var render_calendar_events = function () {
            event_list = dashboard_events.fullCalendar('clientEvents');
            $('#event-list').html(' ');
            $.each(event_list, function () {
                var monthNames = [
                    "Jan", "Feb", "Mar",
                    "Apr", "May", "Jun", "Jul",
                    "Aug", "Sep", "Oct",
                    "Nov", "Dec"
                ];
                var starts = this.start._d;
                var ends = this.end._d;
                var start_day = starts.getDate();
                var start_monthIndex = starts.getMonth();
                var start_year = starts.getFullYear();
                var end_day = ends.getDate();
                var end_monthIndex = ends.getMonth();
                var end_year = ends.getFullYear();

                var start_date = monthNames[start_monthIndex] + ', ' + start_day;
                var end_date = monthNames[end_monthIndex] + ', ' + end_day;

                $('#event-list').html('<h4>' + this.title + '</h4><p>Starts: ' + start_date + ' - Ends: ' + end_date + '</p>');
            });
        }

        skyconsOptions = {
            "color": "#fff",
            "resizeClear": true
        }

        var skycons = new Skycons(skyconsOptions);
        skycons.add("demo-weather-sm-icon", Skycons.RAIN);
        skycons.play();

        function WinMove() {
            var element = ".dropzone";
            var handle = ".dragzone";
            var connect = ".dropzone";
            $(element).sortable(
                    {
                        handle: handle,
                        connectWith: connect,
                        tolerance: 'pointer',
                        forcePlaceholderSize: true,
                        opacity: 0.8,
                        start: function (event, ui) {
                            $('.dropzone').addClass('drop-active');
                        },
                        stop: function (event, ui) {
                            $('.dropzone').removeClass('drop-active');
                        }
                    }
                    )
                    .disableSelection();
        }

        var reset_edit = function () {
            var asideHidden2 = jQuery('#container').hasClass('aside-hidden');
            if (asideHidden2) {
                jQuery('#container.aside-in #content-container, #container.aside-in:not(.mainnav-in) #footer').css('padding-right', '0px');
                jQuery('#aside-container').css('right', '-320px');
            }
            else {
                jQuery('#container.aside-in #content-container, #container.aside-in:not(.mainnav-in) #footer').css('padding-right', '320px');
                jQuery('#aside-container').css('right', '0px');
            }
        }


        @if($currentUser->isAdmin())
        $(document).ready(function () {
            reset_edit();
            WinMove();
            $('#aside-toggle').on('click', function () {
                var asideHidden = $('body').hasClass('aside-hidden');
                if (asideHidden) {
                    $(this).html('Stop editing');
                    $('body').removeClass('aside-hidden');
                    $('#container.aside-in #content-container, #container.aside-in:not(.mainnav-in) #footer').animate(
                            {
                                'padding-right': '320px'
                            }
                    );
                    $('#aside-container').animate(
                            {
                                'right': '0px'
                            }
                    );
                } else {
                    $(this).html('Edit dashboard');
                    $('body').addClass('aside-hidden');
                    $('#container.aside-in #content-container, #container.aside-in:not(.mainnav-in) #footer').animate(
                            {
                                'padding-right': '0px'
                            }
                    );
                    $('#aside-container').animate(
                            {
                                'right': '-320px'
                            }
                    );
                }
            });
        });
        @endif

        // var widgetsOrder = [];
        // var sort_widgets = function(){
        //   jQuery('.dropzone').each(function(){
        //     var theId = jQuery(this).attr('id');

        //     var section = { widgets: [] };
        //     section_name = theId;
        //     var self = this[section_name];
        //     jQuery(this).find('.widget').each(function(){
        //       self.widgets.push(jQuery(this).data('widget'));
        //     });
        //   });
        // }

        var user_progress_morris = Morris.Donut({
            element: 'demo-morris-donut',
            data: course_data(),
            colors: [
                '#9CC96B',
                '#50C7A7',
                '#EBAA4B',
                '#F76C51'
            ],
            resize: true
        });

    </script>

    @if (Auth::user()->show_tutorial)
        @include('partials.dashboard.tutorial')
        <script src="assets/js/app/widgets/tutorial.js"></script>
    @endif
@stop
