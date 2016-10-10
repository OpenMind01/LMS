@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal', 'files' => true]) !!}

    @include('include.formpanel.begin', ['title' => 'Import users'])

    @include('include.inputs.begin', ['name' => 'csv', 'caption' => 'CSV file'])
    {!! Form::file('csv', ['class' => 'form-control']) !!}
    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'delimiter', 'caption' => 'Delimiter'])
    {!! Form::select('delimiter', $delimiters, Input::old('delimiter'), ['class' => 'form-control']) !!}
    @include('include.inputs.end')

    @include('include.formpanel.buttons')

    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.show', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop