@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Clone course \'' . $course->name .'\''])

    @include('include.inputs.text', [
        'name' => 'name',
        'caption' => 'Name',
        'required' => true
    ])

    @if(count($clientsToManage))
        @include('include.inputs.select', [
            'name' => 'client_id',
            'caption' => 'Select a client if you want to copy the course to another client',
            'values' => $clientsToManage,
            'required' => false,
        ])
    @endif

    @include('include.formpanel.buttons')

    {!! Form::submit('Clone', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.manage.courses.index', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop