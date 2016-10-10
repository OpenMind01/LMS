@extends('layouts.default')

@section('page-title') Create User @stop

@section('content')
    {!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'PUT', 'class' => 'form form-horizontal', 'files' => true]) !!}

    @include('include.formpanel.begin', ['title' => 'Edit User: ' . $user->full_name])

    @include('pages.admin.users.form')

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
    <a href="{{route('admin.users.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop