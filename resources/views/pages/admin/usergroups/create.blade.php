@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => ['admin.usergroups.store'], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Create a new User group'])

    @include('pages.admin.usergroups.form')

    <div class="form-group">
        {!! Form::label('course_id', 'Course', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
        {!! Form::select('course_id', $coursesList, null, [
            'id' => 'course_id',
            'class' => 'form-control',
            'data-placeholder' => 'Choose a Course...']) !!}
        </div>
    </div>

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.usergroups.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/chosen/chosen.css"/>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script>
        $('#course_id').chosen();
    </script>
@stop