@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Article Action</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($articleAction, ['route' => ['clients.manage.courses.modules.articles.actions.update', $client->slug, $course->slug, $module->slug, $article->id, $articleAction->id], 'method' => 'PUT','class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.courses.modules.articles.actions.form')

            {!! Form::submit('Update Article Action', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop