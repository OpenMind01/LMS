@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
    'title' => $client->name . ': ' . $clientUsergroup->usergroup->title . ': Users',
    'buttons' => [[
        'url' => route('clients.manage.usergroups.users.create', [$client->slug, $clientUsergroup->id]),
        'class' => 'success',
        'title' => 'Invite users'
        ]]
    ])

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-sm-2">Email</th>
            <th class="col-sm-2">Full name</th>
            {{--<th class="col-sm-2">% Dismissed</th>--}}
            {{--<th class="col-sm-7">Body</th>--}}
            {{--<th class="col-sm-1">&nbsp;</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($clientUsergroup->users as $user)
            <tr>
                <td>{{$user->email}}</td>
                <td>{{$user->full_name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('include.panel.end')
@stop