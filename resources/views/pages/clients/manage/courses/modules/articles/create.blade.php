@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Article for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.courses.modules.articles.store', $client->slug, $course->slug, $module->slug], 'class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.courses.modules.articles.form')

            {!! Form::submit('Create Article', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop