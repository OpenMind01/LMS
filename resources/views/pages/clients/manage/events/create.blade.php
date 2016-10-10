@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => ['clients.manage.events.store', $client->slug], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Create a new Event'])

    @include('pages.admin.events.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
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