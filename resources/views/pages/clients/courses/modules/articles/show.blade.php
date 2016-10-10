@inject('assetService', 'Pi\Utility\Assets\AssetStorageService')
@inject('quizService', 'Pi\Clients\Courses\Quizzes\Scoring\QuizScoringService')
@inject('userProgressService', 'Pi\Clients\Courses\Services\UserProgressService')
@inject('articlesService', 'Pi\Clients\Courses\Services\ArticlesService')
@inject('actionService', 'Pi\Clients\Courses\Services\ArticleActionService')

@extends('layouts.default')

@section('containerClasses', 'aside-in aside-right aside-bright')

@section('breadcrumbs-container')
@stop

@section('content')


    <button id="aside-toggle" class="btn btn-md btn-rounded btn-default" onclick="$('body').toggleClass('aside-hidden'); localStorage.hideRightSidebar = $('body').hasClass('aside-hidden')?'yes':'no';">
        <span class="is-aside-visible"><i class="fa fa-caret-square-o-right"></i> <span>Hide Resources</span></span>
        <span class="is-aside-hidden"><i class="fa fa-caret-square-o-left"></i> <span>Show Resources</span></span>
    </button>
    <div id="page-title" style="padding-left: 0; padding-top: 0;">

        <h1 class="page-header text-overflow">
            @can('manage', $article)
                @if(!Request::is('*edit'))
                    <a href="{{ route('clients.courses.modules.articles.edit', [
                                'clientSlug' => $client->slug,
                                'courseSlug' => $course->slug,
                                'moduleSlug' => $module->slug,
                                'articleNumber' => $article->number
                            ]) }}" class="btn btn-success">Edit</a>
                @else
                    <a href="{{ route('clients.courses.modules.articles.show', [
                                'clientSlug' => $client->slug,
                                'courseSlug' => $course->slug,
                                'moduleSlug' => $module->slug,
                                'articleNumber' => $article->number
                            ]) }}" class="btn btn-success">Show</a>
                @endif
            @endcan
            <span class="panel-title-editable" data-id="name">{{ $article->name }}</span>
        </h1>

        <ol class="breadcrumb courses-nav">
            <li><a href="#">Home</a></li>
            <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
            <li>
                <div class="btn-group btn-group-sm breadcrumb-dropdown">
                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                        {{ $course->name }} <i class="dropdown-caret fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @foreach(\Auth::user()->courses as $acourse)
                            <li><a href="/c/{{ $client->slug }}/courses/{{ $acourse->slug }}">{{ $acourse->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li>
                <div class="btn-group btn-group-sm breadcrumb-dropdown">
                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                        {{$module->name}} <i class="dropdown-caret fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @foreach($course->modules as $amodule)
                            <li><a href="/c/{{ $client->slug }}/courses/{{ $course->slug }}/{{ $amodule->slug }}">{{ $amodule->number }}. {{ $amodule->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="active">
                <div class="btn-group btn-group-sm breadcrumb-dropdown">
                    <button class="dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
                        {{ $article->name }} <i class="dropdown-caret fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @foreach($module->articles as $aarticle)
                            <li><a href="{{ route('clients.courses.modules.articles.show', [
                                'clientSlug' => $client->slug,
                                'courseSlug' => $course->slug,
                                'moduleSlug' => $module->slug,
                                'articleNumber' => $aarticle->number
                            ]) }}">{{ $aarticle->number }}. {{ $aarticle->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ol>

    </div>

    <section id="lesson-content">

        <!-- READ -->
        <div class="tab-base lesson-section lesson-visible" id="read-section">
            <div class="tab-content">
                @foreach($article->topics as $key => $topic)
                        <!-- PAGE 1 -->
                <div id="topic_{{$key}}" class="tab-pane @if($key == 0) active @endif read-pane">
                    <div class="row mode-toggler mode-bottom">
                        <div class="col-sm-9">
                            <div class="body-editable" data-id="body" style="min-height: 40px;">
                                @if(Request::is('*edit'))
                                    {!! $article->body !!}
                                @else
                                    {!! Snippet::process($topic->body, $viewData) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if(!Request::is('*edit'))
                <ul id="topics" class="nav nav-tabs">
                    @foreach($article->topics as $key => $topic)
                        <li
                            class="
                                @if($key == 0)
                                    active
                                @endif
                                @if(sizeof($article->topics) == 1)
                                    hidden
                                @endif
                            "
                        >
                            <a data-toggle="tab" class="read-tab add-tooltip" href="#topic_{{$key}}" @if($key == 0) aria-expanded="true" @endif data-page="{{ $key+1 }}">{{ $topic->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- WATCH -->
        @if($article->watchActions->count())
        <div id="watch-section" class="lesson-section">
            <div class="tab-base">
                <div class="tab-content">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $course->name }}: {{ $module->number }}. {{$module->name}}: {{ $article->number }}. {{ $article->name }}</h3>
                    </div>
                    <hr>

                    @foreach($article->watchActions as $key => $watch)
                    <div id="watch_{{$key}}" class="tab-pane @if($key == 0) active @endif read-pane">
                        <div class="row mode-toggler mode-bottom">
                            <div class="col-sm-9">
                                <div class="panel-body" data-id="body">

                                    <h2>{{ $watch->title }}</h2>

                                    <div style="max-width:640px">
                                        <div class="videoWrapper">
                                            <div id="v_watch_{{ $key }}">
                                            </div>
                                        </div>
                                    </div>

                                    <p>{{ $watch->description }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <ul id="watch" class="nav nav-tabs">
                    @foreach($article->watchActions as $key => $watch)
                        <li @if($key == 0) class="active" @endif>
                            <a data-toggle="tab" class="watch-tab add-tooltip" href="#watch_{{$key}}" @if($key == 0) aria-expanded="true" @endif data-page="{{ $key+1 }}">{{ $watch->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- WATCH -->
        @if($article->listenActions->count())
        <div id="listen-section" class="lesson-section">
            <div class="tab-base">
                <div class="tab-content">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $course->name }}: {{ $module->number }}. {{$module->name}}: {{ $article->number }}. {{ $article->name }}</h3>
                    </div>
                    <hr>

                    @foreach($article->listenActions as $key => $listen)
                    <div id="listen_{{$key}}" class="tab-pane @if($key == 0) active @endif read-pane">
                        <div class="row mode-toggler mode-bottom">
                            <div class="col-sm-9">
                                <div class="panel-body" data-id="body">

                                    <h2>{{ $listen->title }}</h2>
                                    <p>{!! $listen->description !!}</p>
                                    <p>
                                        <audio data-id="{{ $listen->id }}" id="listen_{{ $key }}" controls>
                                            <source src="{{ $listen->url }}" type="audio/mpeg">
                                        </audio>
                                    </p>



                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <ul id="listen" class="nav nav-tabs">
                    @foreach($article->listenActions as $key => $listen)
                        <li @if($key == 0) class="active" @endif>
                            <a data-toggle="tab" class="listen-tab add-tooltip" href="#listen_{{$key}}" @if($key == 0) aria-expanded="true" @endif data-page="{{ $key+1 }}">{{ $listen->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- DO -->
        <div id="do-section" class="lesson-section">
            Do
        </div>

        <!-- QUIZ -->
        <div id="answer-section" class="lesson-section">
            Answer
        </div>

    </section>

    @if(count($article->assets) > 0)
    <!-- Gallery -->
    <div class="row">
        <div class="col-sm-12">
            <div id="demo-panel-ref" class="panel gallery-panel">
                <!--Panel heading-->
                <div class="panel-heading">
                    <div class="panel-control">
                        <div class="btn-group">
                            {{-- <button class="btn btn-info toggle-gallery">
                                Move <i class="fa fa-caret-square-o-right fa-lg"></i>
                            </button> --}}
                        </div>
                    </div>
                    <h3 class="panel-title">Gallery</h3>
                </div>

                <!--Panel body-->
                <div class="panel-body">
                    <div class="gallery-images">
                        <div class="row">
                            @foreach($article->assets as $asset)
                                <div class="col-sm-3 gallery-asset">
                                    <a title="{{ $asset->caption }}" class="image img-responsive" href="{{ $assetService->getUrlForAsset($asset) }}">
                                        <img class="img-responsive" src="{{ $assetService->getUrlForAsset($asset) }}" />
                                        <p>{{ $asset->caption }}</p>
                                    </a>
                                    @if(Request::is('*edit'))
                                        {!! Form::open(['route' => ['api.articles.gallery.destroy', $article->id, $asset->id], 'method' => 'DELETE', 'class' => 'delete-gallery-form', 'files' => true, 'id' => 'my-dropzone']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                                <div id="dropzone-tmpl" style="display:none;">
                                    <div class="dz-preview dz-file-preview">
                                      <div class="dz-image"><img data-dz-thumbnail /></div>
                                      <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size></span></div>
                                        <div class="dz-filename"><span data-dz-name></span></div>
                                      </div>
                                      <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                      <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                      <div class="dz-success-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                          <title>Check</title>
                                          <defs></defs>
                                          <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                          </g>
                                        </svg>
                                      </div>
                                      <div class="dz-error-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                          <title>Error</title>
                                          <defs></defs>
                                          <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                              <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                            </g>
                                          </g>
                                        </svg>
                                      </div>
                                      <div class="add-caption" style="display:none;">
                                          <a href="#" class="btn btn-primary btn-xs">Add Caption</a>
                                          <input placeholder="Add a caption and press enter to save..." class="form-control add-caption-field" type="text" style="display:none;" >
                                      </div>
                                    </div>
                                </div>

                            @endforeach
                            @if(Request::is('*edit'))
                                <div class="col-sm-12">
                                    {!! Form::open(['route' => ['api.articles.gallery.store', $article->id], 'class' => 'dropzone', 'files' => true, 'id' => 'my-dropzone']) !!}
                                    {!! Form::token() !!}
                                    {!! Form::close() !!}
                                </div>
                            @endif
                            <style>
                                .dropzone{
                                    border: 3px dashed #eee !important;
                                    border-radius: 16px !important;
                                    padding: 0px !important;
                                    line-height: 100px;
                                    min-height: 100px !important;
                                    font-size: 24px;
                                    color: #ccc;
                                    margin: 0 20px;
                                }
                                .gallery-asset .btn-danger{
                                    margin: 0px auto;
                                    display: block;
                                    position: relative;
                                    top: -40px;
                                }
                                .image{
                                    border-radius: 10px;
                                    padding: 5px;
                                    float: none;
                                }
                                .add-caption{
                                    line-height: 100%;
                                    text-align: center;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Gallery -->
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div id="pi">
            </div>
        </div>
    </div>

    <div class="row" style="padding-top: 20px;">
        <div class="col-sm-12">
            <!-- Refer to public/assets/js/app/controllers/ArticleProgressWidget/ArticleProgressWidget.controller.js -->
            <div class="panel panel-colorful" id="article-progress" style="display: none;"
                ng-controller="ArticleProgressWidgetController as widget"
                ng-class="{ 'panel-success': widget.getCompletedPercentage() == 100, 'panel-primary': widget.getCompletedPercentage() != 100, show: 1 }"
            >
                <div class="pad-all media">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs">
                            <i class="fa fa-tasks fa-2x" ng-if="widget.getCompletedPercentage() != 100"></i>
                            <i class="fa fa-thumbs-up fa-2x" ng-if="widget.getCompletedPercentage() == 100"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p class="h3 text-thin media-heading" ng-if="widget.getCompletedPercentage() != 100">Things to do to finish the article...</p>
                        <p class="h3 text-thin media-heading" ng-if="widget.getCompletedPercentage() == 100">Awesome job! The article is now complete</p>
                        <div class="text-uppercase h4">
                            <span data-step="<% ($index) %>" class="label label-success pi-button" style="margin-right: 5px;"
                                ng-repeat="section in widget.sections"
                                ng-class="{ 'label-success': section.status == 'completed', 'label-warning': section.status != 'completed' }"
                            >
                                <i class="fa fa-check" ng-if="section.status == 'completed'"></i>
                                <i class="fa fa-circle-o" ng-if="section.status != 'completed'"></i>
                                <% ($index + 1) %>. <% section.name %>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="progress progress-xs progress-dark-base mar-no">
                    <div role="progressbar" aria-valuenow="<% widget.getCompletedPercentage() %>" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-light" style="width: <% widget.getCompletedPercentage() %>%"></div>
                </div>
                <div class="pad-all text-right">
                    <small ng-if="widget.getCompletedPercentage() == 100">
                        <a href="<% widget.prev_article.url %>" class="btn btn-green" ng-if="widget.prev_article"><i class="fa fa-arrow-left"></i> <strong>Back</strong>
                        <a href="<% widget.next_article.url %>" class="btn btn-default btn-rounded">Next <i class="fa fa-arrow-right"></i></a>

                    </small>
                    <small ng-if="widget.getCompletedPercentage() != 100">
                        <span class="text-semibold"><% widget.getCompletedPercentage() %>%</span> Done
                    </small>
                </div>

                <!-- The hidden input is added to tell angular that some outside variable has changed by jquery -->
                <!-- Ideally, PI buttons and similar have to be redone with angular to reduce codebase and make it more structured -->
                <input type="text" style="display: none;" ng-model="widget.dummy" id="article-show-angular-bridge-input">

            </div>
        </div>
    </div>

    <div class="row" style="display: none;">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        @if($article->watchAction)
                            <div class="col-sm-3" class="action-watch">
                                <div class="icon">
                                    <a href="#">
                                        <i class="fa fa-eye fa-4x"></i>
                                    </a>
                                </div>
                                <div class="title">
                                    Watch
                                </div>
                            </div>
                        @endif
                        @if($article->listenAction)
                            <div class="col-sm-3" class="action-listen">
                                <div class="icon">
                                    <a href="#">
                                        <i class="fa fa-volume-up fa-4x"></i>
                                    </a>
                                </div>
                                <div class="title">
                                    Listen
                                </div>
                            </div>
                        @endif
                        @if($article->doQuiz)
                            <div class="col-sm-3" class="action-do">
                                <div class="icon">
                                    <a href="{{ route('clients.courses.modules.articles.quizzes.show', [$client->slug, $course->slug, $module->slug, $article->number, $article->doQuiz->id]) }}">
                                        <i class="fa fa-map fa-4x"></i>
                                    </a>
                                </div>
                                <div class="title">
                                    Do
                                </div>
                            </div>
                        @endif
                        @if($article->answerQuiz)
                            <div class="col-sm-3" class="action-answer">
                                <div class="icon">
                                    <a href="{{ route('clients.courses.modules.articles.quizzes.show', [$client->slug, $course->slug, $module->slug, $article->number, $article->answerQuiz->id]) }}">
                                        <i class="fa fa-graduation-cap fa-4x"></i>
                                    </a>
                                </div>
                                <div class="title">
                                    Answer
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @if($article->answerQuiz && $article->answerQuiz->attempts->count())
                @foreach($article->answerQuiz->attempts as $key => $attempt)
                    Answer Attempt #{{ $key+1 }}: {{ $attempt->score }}% (
                    <a href="{{ route('clients.courses.modules.articles.quizzes.attempts.show', [$client->slug, $course->slug, $module->slug, $article->number, $article->answerQuiz->id, $attempt->id]) }}">
                        View Results
                    </a>
                    )
                @endforeach
            @endif
                @if($article->doQuiz && $article->doQuiz->attempts->count())
                    @foreach($article->doQuiz->attempts as $key => $attempt)
                        Do Attempt #{{ $key+1 }}: {{ $attempt->score }}% (
                        <a href="{{ route('clients.courses.modules.articles.quizzes.attempts.show', [$client->slug, $course->slug, $module->slug, $article->number, $article->doQuiz->id, $attempt->id]) }}">
                            View Results
                        </a>
                        )
                    @endforeach
                @endif
        </div>
    </div>
@stop

@section('aside')
    @include('pages.clients.courses.modules.articles.partials.aside');
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/raptor-editor/raptor-front-end.min.css">
    <link rel="stylesheet" href="/assets/plugins/dropzone/dist/dropzone.css">
    <style>
    .article-tooltip {
        position: relative;
        display: inline;
        border-bottom: 1px dotted rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .article-tooltip-body {
        display: none;
        cursor: default;
        position: absolute;
        bottom: 100%;
        left: 50%;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
        border: 1px solid #888;
        -webkit-transform: translate:(-50%);
                transform: translateX(-50%);

        box-sizing: border-box;
        z-index: 50;
    }

    .article-tooltip-inner {
        position: relative;
        padding: 15px;
        width: 300px;
        max-height: 400px;
        overflow-y: scroll;

    }

    .article-tooltip-body img {
        max-width: 100%;
    }

    .article-tooltip-close {
        cursor: pointer;
        position: absolute;
        width: 20px;
        top: -10px;
        right: -10px;
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
    }

    .article-tooltip-close:after {
        content: '×';
        text-align: center;
        display: block;
        line-height: 20px;
    }
    </style>
    <style>
        .content-box {
            display: inline-block;
        }
        .content-box img {
            display: none;
        }
        .content-box .title {
            color: #991816;
            /*text-decoration: underline;*/
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
        }
        .content-box .content {
            display: none;
        }
        .pi-button{
            cursor: pointer;
        }
        #pi{
            display: none;
        }
    </style>
@stop


@section('inline-scripts')
    <script src="/assets/plugins/dropzone/dist/dropzone.js"></script>
    <script src="http://www.youtube.com/player_api"></script>
    <script>
        var current_section = 0;

        // User Settings
        var user_settings = {
            sidebarStatus: 1
        };

        var available_sections = [
            {
                name: 'Read',
                slug: 'read',
                status: @if($articlesService->userHasReadArticle($article, $currentUser)) 'completed' @else 'current' @endif , /* current, completed, locked */
                currentTopic: 1
            },
            @if($article->watchActions->count())
            {
                name: 'Watch',
                slug: 'watch',
                status: 'locked',
                contents: [
                    @foreach($article->watchActions as $watch)
                        {
                            id: "{{ $watch->id }}",
                            title: "{{ $watch->title }}",
                            url: "{{ $watch->url }}",
                            description: "{{ json_encode($watch->description) }}",
                            completed: {{ $actionService->userHasCompletedAction($watch, $currentUser) }},
                        },
                    @endforeach
                ]
            },
            @endif
            @if($article->listenActions->count())
            {
                name: 'Listen',
                slug: 'listen',
                status: 'locked',
                contents: [
                    @foreach($article->listenActions as $listen)
                        {
                            id: "{{ $listen->id }}",
                            title: "{{ $listen->title }}",
                            url: "{{ $listen->url }}",
                            description: "{{ json_encode($listen->description) }}",
                            completed: {{ $actionService->userHasCompletedAction($listen, $currentUser) }},

                        },
                    @endforeach
                ]
            },
            @endif
            @if($article->doQuiz)
            {
                name: 'Do',
                slug: 'do',
                status: @if($quizService->userHasPassedQuiz($article->doQuiz, $currentUser)) 'completed' @else 'locked' @endif,
                url: '{{ route("clients.courses.modules.articles.quizzes.show", [$client->slug, $course->slug, $module->slug, $article->number, $article->doQuiz->id]) }}'
            },
            @endif
            @if($article->answerQuiz)
            {
                name: 'Answer',
                slug: 'answer',
                status: @if($quizService->userHasPassedQuiz($article->answerQuiz, $currentUser)) 'completed' @else 'locked' @endif,
                url: '{{ route("clients.courses.modules.articles.quizzes.show", [$client->slug, $course->slug, $module->slug, $article->number, $article->answerQuiz->id]) }}'
            }
            @endif
        ];


        @if (!empty($nextArticle))
        var next_article = {
            url: '{{ $nextArticleUrl }}',
            name: '{{ $nextArticle->number }}. {{ $nextArticle->name }}',
        };
        @endif

        @if (!empty($prevArticle))
            var prev_article = {
                url: '{{ $prevArticleUrl }}',
                name: '{{ $prevArticle->number }}. {{ $prevArticle->name }}',
            };
        @endif

        // YouTube Funcs
        @foreach($article->watchActions as $key => $watch)
        var watch_{{ $key }};
        @endforeach
        function onYouTubePlayerAPIReady() {
            @foreach($article->watchActions as $key => $watch)
            <?php
                parse_str( parse_url( $watch->url, PHP_URL_QUERY ), $output );
            ?>
            watch_{{ $key }} = new YT.Player('v_watch_{{ $key }}', {
              height: '390',
              width: '640',
              videoId: '{{ $output["v"] }}',
              events: {
                onStateChange: function(event){
                    if(event.data === 0) {
                        mark_topic_completed('watch', {{ $key }});
                        url = '/api/articles/'+window.Pi.article.id+'/actions/{{ $watch->id }}/mark-complete';
                        $.ajax({
                            url: url,
                            type: 'post',
                            success: function(response) {
                                console.log(response);
                            }
                        });
                        if($('.watch-tab.completed').length === $('.watch-tab').length){
                            available_sections[current_section].status = 'completed';
                            renderButtons();
                        }
                    }
                }
              }
            });
            @endforeach
        }

        // Listen Funcs
        $("audio").bind("ended", function() {
            var id = $(this).attr('id');
            var audio_id = $(this).data('id');
            id = id.split('_');
            url = '/api/articles/'+window.Pi.article.id+'/actions/'+audio_id+'/mark-complete';
            $.ajax({
                url: url,
                type: 'post',
                success: function(response) {
                    console.log(response);
                    mark_topic_completed('listen', id[1]);
                }
            });
        });

        (function ($) {
            Dropzone.options.myDropzone = {
                init: function() {
                    this.on("complete", function(file) { $('.add-caption').fadeIn(); });
                },
                previewTemplate: $("#dropzone-tmpl").html()
            };
            $(document).on('click', '.add-caption .btn', function(e){
                e.preventDefault();
                $(this).hide();
                $('.add-caption-field').show().focusIn();
            });
        })(jQuery);

        $('[data-topic-link]').on('click', function(eventObject) {
            if ($(this).closest('.raptor-editing').length) {
                return;
            }

            eventObject.preventDefault();
            var href = $(this).attr('href');

            $('#topics > .active').removeClass('active');
            $('#topics [href="' + href + '"]').closest('li').addClass('active');
            $('#lesson-content').find('.tab-pane.active').removeClass('active');
            $(href).addClass('active');
        });

        $('.article-tooltip').on('click', function(eventObject) {
            eventObject.preventDefault();
            eventObject.stopPropagation();
            $(this).find('.article-tooltip-body').toggle();
        });

        $('.article-tooltip-close').on('click', function(eventObject) {
            eventObject.preventDefault();
            eventObject.stopPropagation();
            $(this).closest('.article-tooltip-body').toggle();
        });

    </script>
    <script>

        window.Pi.article = {
            id: '{{ $article->id }}',
            name: '{{ $article->name }}'
        };
        console.log(window.Pi);

    </script>
    <script type="text/javascript" src="/assets/js/p4.js"></script>
    <script>
        if(available_sections[0].slug === 'read' && available_sections[0].status === 'completed') {
            $('#topics.nav-tabs li').each(function(){
                var id = $(this).find('a').attr('href').split('_');
                mark_topic_completed('topic', id[1]);
            });
        }
        $.each(available_sections, function(index, value){
            if(value.slug === 'watch'){
                $.each(value.contents, function(index2, value2){
                    if(value2.completed){
                        mark_topic_completed('watch', index2);
                    }
                });
            }
            if(value.slug === 'listen'){
                $.each(value.contents, function(index3, value3){
                    if(value3.completed){
                        mark_topic_completed('listen', index3);
                    }
                });
            }
        });

        $.each(available_sections, function(index,value){
            if($('.'+value.slug+'-tab.completed').length === $('.'+value.slug+'-tab').length && value.slug !== 'do' && value.slug !== 'answer'){
                available_sections[index].status = 'completed';
                renderButtons();
            }
        });
    </script>

    <script>
        (function ($) {
            $(".content-box .title")
                .popover({
                    trigger: 'click',
                })
                .click(function() {
                    var $contentBox = $(this).closest('.content-box');
                    var title = $(this).text();
                    $(this).css({
                        color: 'green'
                    })
                    var content = $contentBox.find('.content').html();
                    var images = [];
                    var message = "<div>"+content+"</div>";
                    var $msg = $(message);
                    $msg.find('img').css({
                        display: 'inline-block',
                    });
//                    message = message + "<div>";
//                    for (var i in images) {
//                        message = message + $('<div>').append(images[i].clone()).html();
//                    }
//                    message = message + "</div>";

                    if ($contentBox.hasClass('modal-content-box')) {
                        console.log('modal');
                        bootbox.dialog({
                            title: title,
                            message: $msg
                        });
                    }

                    if ($contentBox.hasClass('tooltip-content-box')) {
                        var $this = $(this);
                        if ($this.toggleClass('active').hasClass('active')) {
                            $this.popover('show');
                            $('.popover-content')
                                    .empty()
                                    .append($msg);
                        } else {
                            $this.popover('hide');
                        }
                    }


                });
        })(jQuery);
    </script>
@stop