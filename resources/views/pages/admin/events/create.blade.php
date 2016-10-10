@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => 'admin.events.store', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Create a new Event'])

    @include('pages.admin.events.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.events.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop