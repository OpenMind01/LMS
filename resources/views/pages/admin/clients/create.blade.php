@extends('layouts.default')

@section('page-title') Create Client @stop

@section('content')
    {!! Form::open(['route' => 'admin.clients.store', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Create a new Client'])

    @include('pages.admin.clients.form', compact('administrators'))

    @include('include.inputs.email', [
        'name' => 'ownersEmail',
        'caption' => 'Owners email',
        'required' => true
    ])

    @include('include.formpanel.buttons')

    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.clients.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/chosen/chosen.css"/>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script>
        $('#industries').chosen({
            placeholder_text_multiple: 'Select Industries'
        });
    </script>
@stop