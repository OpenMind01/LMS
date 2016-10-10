@extends('layouts.default')
@inject('userProgress', 'Pi\Clients\Courses\Services\UserProgressService')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="#">Courses</a></li>
    <li><a href="{{ route('clients.courses.show', [$client->slug, $course->slug]) }}">{{ $course->name }}</a></li>
    <li class="active">{{ $module->name }}</li>
@stop
@section('content')
    <div class="course-module">

        <div class="panel">
            <div class="panel-heading">
                @can('manage', $module)
                <div class="panel-control">
                    <a href="{{ route('clients.courses.modules.edit', [
                                'clientSlug' => $client->slug,
                                'courseSlug' => $course->slug,
                                'moduleSlug' => $module->slug
                            ]) }}" class="btn btn-success">Edit</a>
                </div>
                @endcan
                <h3 class="panel-title">{{ $course->number }}.{{ $module->number }}: {{ $module->name }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Article</th>
                        <th>Completion %</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($module->articles as $key => $article)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $article->name }}</td>
                        <td>{{ $userProgress->getArticleCompletionPercentageForUser($article, $currentUser) }}%</td>
                        <td>
                            <a href="{{ route('clients.courses.modules.articles.show', [
                                'clientSlug' => $client->slug,
                                'courseSlug' => $course->slug,
                                'moduleSlug' => $module->slug,
                                'articleNumber' => $article->number
                            ]) }}">
                                Enter
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop