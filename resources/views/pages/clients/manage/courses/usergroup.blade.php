@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Create user group from course \'' . $course->name .'\''])

    @include('include.inputs.text', [
        'name' => 'name',
        'caption' => 'Name',
        'required' => true,
        'default' => $defaultTitle
    ])

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.manage.courses.index', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop