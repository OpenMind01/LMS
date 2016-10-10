@extends('layouts.default')

@section('content')
    {!! Form::model($event, ['route' => ['admin.events.update', $event->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Edit Event'])

    @include('pages.admin.events.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.events.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop