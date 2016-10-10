@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Clone ' . $industry->title])

    @include('include.inputs.text', [
        'name' => 'title',
        'caption' => 'Title',
        'required' => true
    ])

    @include('include.formpanel.buttons')

    {!! Form::submit('Clone', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.industries.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop