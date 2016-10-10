@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Resource for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.resources.store', $client->slug], 'files' => true, 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.resources.form')

            {!! Form::submit('Create Resource', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop