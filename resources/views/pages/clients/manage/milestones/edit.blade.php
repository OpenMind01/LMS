@extends('layouts.default')

@section('inline-styles')
    <link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
@stop

@section('content')
    {!! Form::model($milestone, [
        'route' => ['clients.manage.milestones.update', $client->slug, $milestone->id],
        'method' => 'put',
        'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Edit milestone'])

    @include('include.inputs.text', [
        'name' => 'title',
        'caption' => 'Title',
        'required' => true,
    ])

    @include('include.inputs.date', [
        'name' => 'string_finish_datetime',
        'caption' => 'Finish date',
        'required' => true,
    ])

    @include('include.formpanel.buttons')

    <input type="submit" class="btn btn-primary" value="Update"/>
    <a class="btn" href="{{route('clients.manage.milestones.index', $client->slug)}}">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-scripts')
    <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <script>
        $(function(){
            $('#string_finish_datetime').parent().datepicker({autoclose:true});
        });
    </script>
@stop