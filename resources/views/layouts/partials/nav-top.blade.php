@inject('impersonate', 'Pi\Auth\Impersonation\Impersonate')

<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#" onclick="setTimeout(function() { localStorage.hideLeftSidebar = $('#container').hasClass('mainnav-sm')?'yes':'no'; }, 1000);">
                        <i class="fa fa-navicon fa-lg"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->

            </ul>
            <ul class="nav navbar-top-links pull-right">


                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
								<span class="pull-right">
									<img class="img-circle img-user media-object" src="/assets/img/av1.png" alt="Profile Picture">
								</span>
                        <div class="username hidden-xs">
                            @if($impersonate->isImpersonating())
                                (Impersonating)
                            @endif
                            {{ $currentUser->full_name }}
                        </div>
                    </a>


                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">

                        <ul class="head-list">
                            @if($impersonate->isImpersonating())
                                <li>
                                    <a href="{{ route('admin.users.unimpersonate') }}">
                                        <i class="fa fa-user fa-fw fa-lg"></i> Stop Impersonating
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{action('Auth\UpdateProfileController@getIndex')}}">
                                    Update profile
                                </a>
                            </li>
                            <li>
                                <a href="{{action('Auth\ChangePasswordController@getIndex')}}">
                                    Change password
                                </a>
                            </li>
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="{{ route('auth.logout') }}" class="btn btn-primary">
                                <i class="fa fa-sign-out fa-fw"></i> Logout
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>