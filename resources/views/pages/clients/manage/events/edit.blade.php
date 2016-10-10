@extends('layouts.default')

@section('content')
    {!! Form::model($event, ['route' => ['clients.manage.events.update', $client->slug, $event->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Edit Event'])

    @include('pages.admin.events.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.manage.events.index', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-styles')
    <link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
@stop

@section('inline-scripts')
    <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <script>
        $(function() {
            $('#string_datetime').parent().datepicker({autoclose: true});
        });
    </script>
@stop