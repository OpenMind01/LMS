@extends('layouts.default')

@section('content')
    {!! Form::model($event, ['route' => ['admin.events.destroy', $event->id], 'method' => 'DELETE', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Delete Event'])

    <div class="form-group text-center">
        Do you want to delete event '{{$event->title}}'?
    </div>

    @include('include.formpanel.buttons')

    {!! Form::submit('Delete', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.events.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop