@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Resource</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($resource, ['route' => ['clients.manage.resources.update', $client->slug, $resource->id], 'files' => true, 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.resources.form')

            {!! Form::submit('Update Resources', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop