@extends('layouts.auth')

@section('content')
    <div class="cls-content">
        {!! Form::model($user, ['method' => 'post', 'class' => 'form form-horizontal']) !!}

        <div class="cls-content-lg panel">
            <div class="panel-heading">
                <h3 class="panel-title">User information</h3>
            </div>
            <div class="panel-body form-body">
                @include('include.inputs.text', [
                    'name' => 'first_name',
                    'caption' => 'First Name',
                    'required' => true])

                @include('include.inputs.text', [
                    'name' => 'last_name',
                    'caption' => 'Last Name',
                    'required' => true])

                @include('include.inputs.text', [
                    'name' => 'phone_mobile',
                    'caption' => 'Phone (Mobile)'])

                @include('include.inputs.text', [
                    'name' => 'phone_work',
                    'caption' => 'Phone (Work)'])

                @include('include.inputs.text', [
                    'name' => 'phone_home',
                    'caption' => 'Phone (Home)'])

                @include('include.inputs.text', [
                    'name' => 'address_street',
                    'caption' => 'Street Address'])

                @include('include.inputs.text', [
                    'name' => 'address_street_2',
                    'caption' => '',
                    'placeholder' => 'Street Address 2'])

                <div class="form-group">
                    {!! Form::label('address_city', ' ', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('address_city', Input::old('address_city'), ['class' => 'form-control', 'placeholder' => 'City']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::text('address_state', Input::old('address_state'), ['class' => 'form-control', 'placeholder' => 'State']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::text('address_postal', Input::old('address_postal'), ['class' => 'form-control', 'placeholder' => 'Zip']) !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group">
                    <label class="col-sm-2">&nbsp;</label>
                    <div class="col-sm-10">
                        {!! Form::submit('Register', ['class' => 'btn btn-primary pull-left']) !!}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@stop