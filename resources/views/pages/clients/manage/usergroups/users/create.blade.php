@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => ['clients.manage.usergroups.users.store', $client->slug, $clientUsergroup->id], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Invite users'])

    @include('include.inputs.textarea', [
        'name' => 'emails',
        'caption' => 'Emails',
        'hint' => 'Write users emails. Possible delimiters: \',\' or newline'
    ])

    @include('include.formpanel.buttons')

    {!! Form::submit('Invite', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.manage.usergroups.users.index', [$client->slug, $clientUsergroup->id])}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop