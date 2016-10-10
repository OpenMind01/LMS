@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Change password'])

    @include('include.inputs.password', [
        'name' => 'current_password',
        'caption' => 'Current password',
        'required' => true,
    ])

    @include('include.inputs.password', [
        'name' => 'new_password',
        'caption' => 'New password',
        'required' => true,
    ])


    @include('include.inputs.password', [
        'name' => 'repeat_password',
        'caption' => 'Repeat new password',
        'required' => true,
    ])

    @include('include.formpanel.buttons')

    <input type="submit" class="btn btn-primary" value="Change password"/>
    <a class="btn" href="{{route('dashboard')}}">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop