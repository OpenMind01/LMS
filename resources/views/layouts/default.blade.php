<!DOCTYPE html>
<html lang="en">

<?php $breadcrumbs = new \Pi\Services\BreadcrumbsService(); ?>
<?php if (isset($currentUser) && $currentUser->hasClient()) $client_settings = $currentUser->client->settings()->first(); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if($breadcrumbs->hasItems())
        <title>{{$breadcrumbs->getTitle()}} | P4Global</title>
    @else
        <title>Dashboard | P4Global</title>
    @endif


    <!--STYLESHEET-->
    <!--=================================================-->

    {{--
    <!--Open Sans Font [ OPTIONAL ] -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="/assets/css/nifty.css" rel="stylesheet">



    <!--Font Awesome [ OPTIONAL ]-->
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!--Animate.css [ OPTIONAL ]-->
    <link href="/assets/plugins/animate-css/animate.min.css" rel="stylesheet">


    <!--Morris.js [ OPTIONAL ]-->
    <link href="/assets/plugins/morris-js/morris.min.css" rel="stylesheet">


    <!--Switchery [ OPTIONAL ]-->
    <link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet">


    <!--Magnific Popip [ OPTIONAL ]-->
    <link href="/assets/plugins/magnific-popup/dist/magnific-popup.css" rel="stylesheet">


    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


    <!--Full Calendar [ OPTIONAL ]-->
    <link href="/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    --}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    @yield('inline-styles')

    {{-- <link href="/assets/css/p4.css" rel="stylesheet"> --}}

    @if(isset($currentUser) && $currentUser->hasClient())

        <link href="/css/theme/{{$currentUser->client->theme->id}}/{{$currentUser->client->theme->updated_at->getTimestamp()}}" rel="stylesheet">
        @if($currentUser->isSuperAdmin())
            <link id="p4-theme" href="/assets/css/themes/type-a/theme-p4.min.css" rel="stylesheet">
        @else
            <link id="p4-theme" href="/assets/css/themes/type-{{ $currentUser->client->theme->style_type }}/{{ $currentUser->client->theme->style_name }}.min.css" rel="stylesheet">
        @endif
    @endif

    <style> 
        #mainnav {
          background: black url(/assets/css/themes/type-a/p4-assets/sidebar-background.png);
          box-shadow: inset 0px 0px 150px black;
        }
        #mainnav .brand-title{
            padding: 0px 10px;
        }
        .brand-title img {
            max-width: 100%;
            width: 100%;
            height: auto;
        }
    </style>

    <!--SCRIPT-->
    <!--=================================================-->

    <script src="/assets/js/jquery-2.1.1.min.js"></script>
    {{--
    <script src="/assets/js/bootstrap.min.js"></script>
    --}}

    {{--
    @if( SOME CONDITIONAL WHERE USER MADE CHANGES TO THE DEFAULT THEME )
    <link id="p4-theme" href="/assets/css/themes/type-{{ $type }}/{{ $name }}.min.css" rel="stylesheet">
    @endif
    --}}

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<!-- Refer to public/assets/js/app/controllers/global/global.controller.js -->
<body ng-app="p4" ng-controller="global as global"
    class="
        @if (!empty($client_settings['widget_settings']['lesson_styles']['sidebars_hidden']))
            aside-hidden
        @endif
    "
>

<div id="container" class="effect mainnav-fixed @yield('containerClasses')
    @if (!empty($client_settings['widget_settings']['lesson_styles']['sidebars_hidden']))
        mainnav-sm
    @else
        mainnav-lg
    @endif
">

    @include('layouts.partials.nav-top')

    <div class="boxed">

        <div id="content-container">

            {{--<div id="page-title">--}}
                {{--<h1 class="page-header text-overflow">@yield('page-title')</h1>--}}
            {{--</div>--}}
            @if($breadcrumbs->hasItems())
                <ol class="breadcrumb" style="margin-top: 12px;">
                    <li><a href="/">Home</a></li>
                    @foreach($breadcrumbs->getBreadcrumbs() as $breadcrumb)
                        <li><a href="{{$breadcrumb->getUrl()}}">{{$breadcrumb->getTitle()}}</a></li>
                    @endforeach
                    <li>{{$breadcrumbs->getTitle()}}</li>
                </ol>
            @else
                @section('breadcrumbs-container')
                    <ol class="breadcrumb" style="margin-top: 12px;">
                        @section('breadcrumbs')
                            <li><a href="/">Home</a></li>
                        @show
                    </ol>
                @show
            @endif

            <div id="page-content">

                @include('layouts.partials.alerts')

                <div class="row">
                    <div class="col-sm-12">
                        @yield('content')
                    </div>
                </div>


            </div>

        </div>


        @include('layouts.partials.nav-left')

        @yield('aside')

    </div>



    <!-- FOOTER -->
    <!--===================================================-->
    <footer id="footer">



        <!-- Visible when footer positions are static -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div class="hide-fixed pull-right pad-rgt">v{{ config('globals.version') }}</div>



        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <p class="pad-lft">&#0169; {{ date('Y') }} P4 Global</p>



    </footer>
    <!--===================================================-->
    <!-- END FOOTER -->


    <!-- SCROLL TOP BUTTON -->
    <!--===================================================-->
    <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
    <!--===================================================-->



</div>
<!--===================================================-->
<!-- END OF CONTAINER -->


<!-- Done with native JS to avoid lags due to onload triggers and other script delays -->
<script>
    if (localStorage.hideRightSidebar) {
        if (localStorage.hideRightSidebar == 'yes') {
            document.getElementsByTagName('body')[0].className += 'aside-hidden';
        }
        else {
            document.getElementsByTagName('body')[0].className = document.getElementsByTagName('body')[0].className.replace('aside-hidden', '');
        }
    }

    if (localStorage.hideLeftSidebar) {
        if (localStorage.hideLeftSidebar == 'yes') {
            document.getElementById('container').className =document.getElementById('container').className.replace('mainnav-lg', 'mainnav-sm');
        }
        else {
            document.getElementById('container').className =document.getElementById('container').className.replace('mainnav-sm', 'mainnav-lg');
        }
    }

</script>



<!--JAVASCRIPT-->
<!--=================================================-->
{{--<script src="/assets/js/jquery-2.1.1.min.js"></script>--}}

<!--BootstrapJS [ RECOMMENDED ]-->
{{--<script src="/assets/js/bootstrap.min.js"></script>--}}
{{--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!--Fast Click [ OPTIONAL ]-->
<script src="/assets/plugins/fast-click/fastclick.min.js"></script>

<!--Nifty Admin [ RECOMMENDED ]-->
<script src="/assets/js/nifty.min.js"></script>


<!--Morris.js [ OPTIONAL ]-->
<script src="/assets/plugins/morris-js/morris.min.js"></script>
<script src="/assets/plugins/morris-js/raphael-js/raphael.min.js"></script>


<!--Sparkline [ OPTIONAL ]-->
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>


<!--Skycons [ OPTIONAL ]-->
<script src="/assets/plugins/skycons/skycons.min.js"></script>


<!--Switchery [ OPTIONAL ]-->
<script src="/assets/plugins/switchery/switchery.min.js"></script>


<!--Bootstrap Select [ OPTIONAL ]-->
<script src="/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<!--Magnific Popup [ OPTIONAL ]-->
<script src="/assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>

<script src="/assets/plugins/bootbox/bootbox.min.js"></script>
<script src="/assets/plugins/bootform/dist/bootform-min.js"></script>


<script src="/assets/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="/assets/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
<script src="/assets/plugins/fullcalendar/fullcalendar.min.js"></script>

@include('partials.snippets.javascript')

<script src="/assets/js/pi/alerts.js"></script>

@yield('inline-scripts')
<script src="/assets/plugins/jquery-dragdrop/modernhtml5.js"></script>
<script src="/assets/js/pi/pages/clients/manage/quizzes/edit.js"></script>


    <!-- Angular assets -->
    <script src="{{ asset('/assets/plugins/angular/angular.js') }}"></script>
    <script src="{{ asset('/assets/plugins/angular-resource/angular-resource.js') }}"></script>
    <script src="{{ asset('/assets/plugins/ngstorage/ngStorage.js') }}"></script>

    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/app/services/client/client.service.js') }}"></script>
    <script src="{{ asset('/assets/js/app/controllers/global/global.controller.js') }}"></script>
    <script src="{{ asset('/assets/js/app/controllers/ClientLessonStyle/ClientLessonStyle.controller.js') }}"></script>
    <script src="{{ asset('/assets/js/app/controllers/ArticleProgressWidget/ArticleProgressWidget.controller.js') }}"></script>
--}}
    {{-- Check out gulpfile.js for the scripts --}}
    <script src="/js/app.js"></script>
    <script src="/js/jquery-ui.js"></script>
    @include('partials.snippets.javascript')
    @yield('inline-scripts')
    <script>
        window.p4angularConstants = {
            @if (isset($currentUser) && $currentUser->hasClient())
                client: {
                    id: {{ $currentUser->client->id }},
                    slug: '{{ $currentUser->client->slug }}',
                    name: '{{ $currentUser->client->name }}',
                    theme: {!! $currentUser->client->theme !!},
                    @if (!empty($client_settings))
                        client_settings: {!! $client_settings !!},
                    @endif
                },
            @endif

            @if (isset($currentUser))
                user: {
                    id: {{ $currentUser->id }},
                    client_id: '{{ $currentUser->client_id }}',
                    name: '{{ $currentUser->name }}',
                    first_name: '{{ $currentUser->first_name }}',
                    last_name: '{{ $currentUser->last_name }}',
                    role: '{!! $currentUser->role !!}',
                },
            @endif

        };
    </script>

</body>
</html>
