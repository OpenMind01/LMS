@extends('layouts.default')
@inject('userProgress', 'Pi\Clients\Courses\Services\UserProgressService')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="#">Courses</a></li>
    <li class="active">{{ $course->name }}</li>
@stop
@section('content')

    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">{{ $course->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Module</th>
                    <th>Completion Percent</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($course->modules as $key => $module)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $module->name }}</td>
                    <td>{{ $userProgress->getModuleCompletionPercentageForUser($module, $currentUser) }}%</td>
                    <td>
                        <a href="{{ route('clients.courses.modules.show', [
                            'clientSlug' => $client->slug,
                            'courseSlug' => $course->slug,
                            'moduleSlug' => $module->slug
                        ]) }}">Enter</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop