@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li><a href="{{ route('clients.manage.buildings.room-attributes.index', [$client->slug]) }}">Manage Client Room Attributes</a></li>
    <li class="active">Edit Room Attribute</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Room Attribute</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($roomAttribute, ['route' => ['clients.manage.buildings.room-attributes.update', $client->slug, $roomAttribute->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.buildings.room-attributes.form')

            {!! Form::submit('Update Room Attribute', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('inline-scripts')

@stop