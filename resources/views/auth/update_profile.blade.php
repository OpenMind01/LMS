@extends('layouts.default')

@section('content')
    {!! Form::model($user, ['class' => 'form form-horizontal', 'files' => true]) !!}

    @include('include.formpanel.begin', ['title' => 'Update profile'])

    <fieldset>
        <legend>Basic info</legend>

        @include('include.inputs.text', [
            'name' => 'first_name',
            'caption' => 'Name',
            'required' => true,
        ])

        @include('include.inputs.text', [
            'name' => 'last_name',
            'caption' => 'Last Name',
            'required' => true,
        ])

        @include('include.inputs.email', [
            'name' => 'email',
            'caption' => 'Email',
            'required' => true,
        ])

        @include('include.inputs.phone', [
            'name' => 'phone_mobile',
            'caption' => 'Mobile tel.',
            'required' => false,
        ])

        @include('include.inputs.phone', [
            'name' => 'phone_home',
            'caption' => 'Home tel.',
            'required' => false,
        ])

        @include('include.inputs.phone', [
            'name' => 'phone_work',
            'caption' => 'Work tel.',
            'required' => false,
        ])

        @include('include.inputs.avatar', [
            'name' => 'avatar',
            'caption' => 'Update Avatar',
            'required' => false,
        ])
    </fieldset>

    <fieldset>
        <legend>Address</legend>

        @include('include.inputs.text', [
            'name' => 'address_country',
            'caption' => 'Country',
            'required' => true,
        ])

        @include('include.inputs.text', [
            'name' => 'address_postal',
            'caption' => 'ZIP code',
            'required' => true,
        ])

        @include('include.inputs.text', [
            'name' => 'address_state',
            'caption' => 'State',
            'required' => true,
        ])

        @include('include.inputs.text', [
            'name' => 'address_city',
            'caption' => 'City',
            'required' => true,
        ])

        @include('include.inputs.text', [
            'name' => 'address_street',
            'caption' => 'Address 1',
            'required' => false,
        ])

        @include('include.inputs.text', [
            'name' => 'address_street_2',
            'caption' => 'Address 2',
            'required' => false,
        ])
    </fieldset>

    @include('include.formpanel.buttons')

    <input type="submit" class="btn btn-primary" value="Update profile"/>
    <a class="btn" href="{{route('dashboard')}}">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop