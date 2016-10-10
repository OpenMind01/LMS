@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li class="active">Create Building</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Building for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.buildings.store', $client->slug], 'class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.buildings.form')

            {!! Form::submit('Create Building', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop