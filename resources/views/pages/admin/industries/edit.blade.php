@extends('layouts.default')

@section('content')
    {!! Form::model($industry, ['route' => ['admin.industries.update', $industry->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Edit Industry'])

    @include('pages.admin.industries.form', compact('currentUsergroups', 'usergroupsList'))

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.industries.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/chosen/chosen.css"/>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script>
        $('#usergroups').chosen({
            placeholder_text_multiple: 'Select user groups'
        });
    </script>
@stop