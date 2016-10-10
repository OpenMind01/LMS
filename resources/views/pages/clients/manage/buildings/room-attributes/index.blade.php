@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li class="active">Room attributes for {{ $client->name }}</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.buildings.room-attributes.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Room Attribute</a>
            </div>
            <h3 class="panel-title">Room Attributes for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Snippet Key</th>
                    <th>Default Value</th>
                    <th>Required?</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roomAttributes as $roomAttribute)
                    <tr>
                        <td>{{ $roomAttribute->name }}</td>
                        <td>{{ $roomAttribute->snippet_key }}</td>
                        <td>{{ $roomAttribute->default_value }}</td>
                        <td>{{ ($roomAttribute->is_required) ? "Yes" : "No" }}</td>
                        <td>
                            <a href="{{ route('clients.manage.buildings.room-attributes.edit', [$client->slug, $roomAttribute->id]) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-pencil"></i>
                                Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop