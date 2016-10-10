@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
    'title' => $client->name . ': User groups',
    'buttons' => [[
        'url' => route($routePrefix . 'create', $client->slug),
        'class' => 'success',
        'title' => 'Create User group'
        ]]
    ])

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-sm-2">Title</th>
            {{--<th class="col-sm-2">% Dismissed</th>--}}
            {{--<th class="col-sm-7">Body</th>--}}
            <th class="col-sm-1">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($client->innerUsergroups as $clientUsergroup)
            <tr>
                <td>{{ $clientUsergroup->usergroup->title }}</td>
                <td>
                    <a href="{{route($routePrefix . 'users.index', [$client->slug, $clientUsergroup->id])}}" class="btn btn-success btn-sm">
                        Users
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('include.panel.end')
@stop