@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => [$routePrefix . 'store', $client->slug], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Create user group'])

    <div class="form-group">
        {!! Form::label('usergroup_id', 'User group', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <select name="usergroup_id" id="usergroup_id" class="form-control">
                @foreach($usergroups as $usergroup)
                    <option value="{{$usergroup->id}}">{{$usergroup->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <a href="{{route($routePrefix . 'index', [$client->slug])}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop