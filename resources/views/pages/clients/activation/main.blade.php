@extends('layouts.default')

@section('content')
    <div class="panel">
        @include('pages.clients.activation.tabs', ['selected' => 'main'])

        {!! Form::model($client, ['class' => 'form form-horizontal']) !!}

        <div class="panel-body">
            @include('include.inputs.text', ['name' => 'name',
                'caption' => 'Client name',
                'required' => true])

            @include('include.inputs.textarea', ['name' => 'description', 'caption' => 'Client description'])
        </div>

        <div class="panel-footer">
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@stop