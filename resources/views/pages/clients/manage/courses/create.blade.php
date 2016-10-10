@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Course for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.courses.store', $client->slug], 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.courses.form')

            {!! Form::submit('Create Course', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop