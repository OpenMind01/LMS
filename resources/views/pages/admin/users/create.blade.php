@extends('layouts.default')

@section('page-title') Create User @stop

@section('content')
    {!! Form::open(['route' => 'admin.users.store', 'class' => 'form form-horizontal', 'files' => true]) !!}

    @include('include.formpanel.begin', ['title' => 'Create a new User'])

    @include('pages.admin.users.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Create User', ['class' => 'btn btn-success']) !!}
    <a href="{{route('admin.users.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop