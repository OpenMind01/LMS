@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li><a href="{{ route('clients.manage.buildings.edit', [$client->slug, $building->id]) }}">Building: {{ $building->name }}</a></li>
    <li class="active">Create Room</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Room for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.buildings.rooms.store', $client->slug, $building->id], 'class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.buildings.rooms.form')

            {!! Form::submit('Create Room', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop