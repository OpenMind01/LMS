@inject('userProgress', 'Pi\Clients\Courses\Services\UserProgressService')
<nav id="mainnav-container">
    <div id="mainnav">

        <a href="/" class="navbar-brand-pi">
            <img src="/assets/img/login-logo.png" alt="The Protection Institute" class="brand-icon">
            <div class="brand-title">
                <img src="/assets/css/themes/type-b/p4-assets/pi-logo.png" alt />
            </div>
        </a>

        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Menu list item-->
                        <li @if(Request::is('dashboard')) class="active-link" @endif>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>

                        @can('industries.manage')
                        <li @if(Request::is('industries*')) class="active-link" @endif>
                            <a href="{{ action('Admin\IndustriesController@index') }}">
                                <i class="fa fa-flag"></i>
                                <span class="menu-title">
                                    Industries
                                </span>
                            </a>
                        </li>
                        @endcan

                        @can('usergroups.manage')
                        <li @if(Request::is('usergroups*')) class="active-link" @endif>
                            <a href="{{ action('Admin\UsergroupsController@index') }}">
                                <i class="fa fa-flag"></i>
                                <span class="menu-title">
                                    User groups
                                </span>
                            </a>
                        </li>
                        @endcan
                        @if(!\Auth::user()->isSuperAdmin() && !\Auth::user()->isAdmin())
                        <li class="list-header">Courses</li>
                            @foreach(\Auth::user()->courses as $course)
                            <?php
                            	$percent = \Pi\Clients\Courses\CourseUser::whereCourseId($course->id)->whereUserId(\Auth::user()->id)->first()->progress_percent;
                            ?>
                            <li>
						    	<a href="/c/{{ \Auth::user()->client->slug }}/courses/{{ $course->slug }}" class="add-tooltip" data-original-title="{{ $percent }}%">
						    		<span class="menu-title">
						    			{{ $course->name }}
						    			<div class="progress progress-sm" style="width:85%;display:inline-block;">
						    				<div class="progress-bar progress-bar-primary" style="width: {{ $percent }}%;">
						    					<span class="sr-only">{{ $percent }}%</span>
						    				</div>
						    			</div>
						    		</span>
						    		<i class="arrow" style="line-height: 0;"></i>
						    	</a>

                                <!--Submenu-->
                                <ul class="collapse" aria-expanded="false" style="height: 0px;">
                                    @foreach($course->modules as $module)
                                        <li>
                                           <a href="/c/{{ \Auth::user()->client->slug }}/courses/{{ $course->slug }}/{{ $module->slug }}">
                                           @if ($module->icon)
                                           <span class="{{$module->icon}} module-sidebar-icon" aria-hidden="true"></span>
                                           @endif
                                           <span> {{ $module->name }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <!--Submenu-->
                            <ul class="collapse" aria-expanded="false" style="height: 0px;">
                                @foreach($course->modules as $module)
                                    <li>
                                        <a href="/c/{{ $course->client->slug }}/courses/{{ $course->slug }}/{{ $module->slug }}">{{ $module->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>


						    @endforeach
                        @endif

                        {{-- @TODO: Add permissions here --}}
                        @if (isset($discussionRoute))
                            <li @if(Request::is('discussion*')) class="active-link" @endif>
                                <a href="{{ route($discussionRoute, $discussionRouteParams) }}">
                                    <i class="fa fa-flag"></i>
                                <span class="menu-title">
                                    Discussions
                                </span>
                                </a>
                            </li>
                        @endif

                        <!--Category name-->
                        @if($currentUser->isSuperAdmin())
                        <li class="list-header">Super-Admin</li>

                        @can('manage', (new Pi\Clients\Client))
                            <li @if(Request::is('admin/clients*')) class="active-link" @endif><a href="{{ route('admin.clients.index') }}">
                                    <i class="fa fa-sitemap"></i>
                                    <span class="menu-title">
                                        Clients
                                    </span>
                                </a>
                            </li>
                        @endcan
                            <li @if(Request::is('admin/users*')) class="active-link" @endif ><a href="{{ route('admin.users.index') }}">
                                    <i class="fa fa-group"></i>
                                    <span class="menu-title">
                                        Users
                                    </span>
                                </a>
                            </li>

                            <li @if(Request::is('admin/events*')) class="active-link" @endif ><a href="{{ route('admin.events.index') }}">
                                    <i class="fa fa-calendar"></i>
                                    <span class="menu-title">
                                        Events
                                    </span>
                                </a>
                            </li>
                        @endif {{-- End role 'Superadmin' --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
