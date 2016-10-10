@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Module for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.courses.modules.store', $client->slug, $course->slug], 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.courses.modules.form')

            {!! Form::submit('Create Module', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop